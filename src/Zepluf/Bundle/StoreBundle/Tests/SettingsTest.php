<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Tests;

use \Zepluf\Bundle\StoreBundle\Settings;
use Symfony\Component\Yaml\Yaml;

class SettingsTest extends BaseTestCase
{
    private $env;
    protected $object;
    private $configDir;
    private $cacheDir;
    private $pluginDir;

    public function setUp()
    {
        $this->configDir = __DIR__ . '/Fixtures/appDir/config';
        $this->cacheDir = __DIR__ . '/Fixtures/appDir/cache';
        $this->pluginDir = __DIR__ . '/Fixtures/appDir/plugin';

        $this->object = $this->get('settings');
    }

    public function testGetCacheRoot()
    {
        $this->assertEquals($this->getParameter('kernel.cache_dir') . "/", $this->object->getCacheRoot());
    }

    public function testInitialize()
    {
        $this->assertFalse($this->object->isInitiated());
        $setting = $this->getMock('Settings');
        $this->object->initialize($setting);
        $this->assertTrue($this->object->isInitiated());
    }

    public function testLoadSettingNoCache()
    {
        $this->object = $this->getFixtureObject();
        $testPlugin = 'riTest';

        //Remove cache folder if existed
        if (file_exists($this->object->getCacheRoot())) {
            $this->delete_directory($this->object->getCacheRoot());
        }

        $this->object->load($testPlugin);

        $this->assertEquals('plugins\Test\Controller\TestController::indexAction', $this->object->get('riTest.routes.test.defaults._controller'));
        $this->assertTrue($this->object->get('riTest.zencart_fallback'));

        $arr = array(1, 2, 3, 4);
        $this->assertEquals($arr, $this->object->get('riTest.test_arr'));
        $this->assertEquals('test', $this->object->get('riTest.test'));
    }

    public function testLoadFile()
    {
        $this->object = $this->getFixtureObject();
        $testPlugin = 'abc';

        $this->object->set($testPlugin, ($this->object->loadFile('', __DIR__ . '/Fixtures/', 'configtestload.yml')));

        $this->assertEquals('Hello World', $this->object->get('abc.test'));
    }

//    public function testLoadTheme()
//    {
////        var_dump($this->object->loadTheme('frontend', __DIR__ . '/Fixtures/', 'theme.yml'));
//        $this->assertEquals('Hello World', $this->object->loadTheme('frontend', __DIR__ . '/Fixtures/', 'theme.yml'));
//    }

    public function testSaveLocal()
    {
        $this->object = $this->getFixtureObject();

        //Load local setting file
        $settings = $this->object->loadFile('plugins', $this->configDir, '/plugins_' . $this->env . '.yml');

        //Save to local
        $this->object->saveLocal(__DIR__ . '/Fixtures/appDir/local/local.yml', $settings);

        //Reload local setting file
        $this->object->set('local', ($this->object->loadFile('', __DIR__ . '/Fixtures/appDir/local/', 'local.yml')));

        //Assertion
        $this->assertFalse($this->object->get('local.ricjloader.settings.cache'));
    }

    public function testSaveCache()
    {
        //Load setting file first
        $this->object = $this->getFixtureObject();

        $local_config = $this->object->loadFile('plugins', $this->configDir, '/plugins_' . $this->env . '.yml');

        //Save cache
        $this->object->saveCache('plugins', $local_config);

        $cache_content = @file_get_contents(__DIR__ . '/Fixtures/appDir/cache/ZePLUF/' . 'plugins_' . $this->env . '.cache');

        $this->assertEquals($cache_content, serialize($local_config));
    }

    public function testLoadCache()
    {
        $this->object = $this->getFixtureObject();

        $local_config = Yaml::parse($this->configDir . '/plugins_' . $this->env . '.yml');

        $settings = $this->object->loadCache('plugins');
        $this->assertEquals($local_config, $settings);
    }

    public function testResetCache()
    {
        $this->object = $this->getFixtureObject();

        //create some junk cache
        $this->object->saveCache('a', array());
        $this->object->saveCache('b', array());
        $this->object->saveCache('c', array());

        //Reset specific cache
        $this->object->resetCache('a');
        //Assertion: no a cache existed
        $this->assertTrue(!file_exists($this->cacheDir . "/ZePLUF/a_" . $this->env . "cache"));

        //Reset all cache
        $this->object->resetCache();
        //Assertion: no cache existed
        $this->assertTrue($this->dir_is_empty($this->cacheDir . "/ZePLUF"));
    }

    public function tearDown()
    {
        unset($this->object);
    }

    private function getFixtureObject()
    {
        unset($this->object);

        return new Settings($this->configDir, $this->cacheDir, $this->pluginDir, $this->env = $this->getParameter('kernel.environment'));
    }

    private function delete_directory($dir)
    {
        if ($handle = opendir($dir)) {
            $array = array();

            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {

                    if (is_dir($dir . $file)) {
                        if (!@rmdir($dir . $file)) // Empty directory? Remove it
                        {
                            $this->delete_directory($dir . $file . '/'); // Not empty? Delete the files inside it
                        }
                    } else {
                        @unlink($dir . $file);
                    }
                }
            }
            closedir($handle);

            @rmdir($dir);
        }
    }

    private function dir_is_empty($dir)
    {
        if (!is_readable($dir)) return NULL;
        return (count(scandir($dir)) == 2);
    }
}
