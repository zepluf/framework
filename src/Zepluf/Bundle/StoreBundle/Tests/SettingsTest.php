<?php
/**
 * Created by RubikIntegration Team.
 *
 * User: Tuan Nguyen
 * Date: 1/10/13
 * Time: 2:12 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Tests;

use \Zepluf\Bundle\StoreBundle\Settings;
use Symfony\Component\Yaml\Yaml;

class SettingsTest extends BaseTestCase
{
    protected $object;
    protected $environment;
    protected $configDir;
    protected $cacheDir;
    protected $pluginDir;

    public function setUp()
    {
        $this->configDir = __DIR__ . '/Fixtures/appDir/config';
        $this->cacheDir = __DIR__ . '/Fixtures/appDir/cache';
        $this->pluginDir = __DIR__ . '/Fixtures/appDir/plugins';
        $this->environment = 'test';

        $this->object = new Settings($this->configDir, $this->cacheDir, $this->pluginDir, $this->environment);
    }

    public function testResetCache()
    {
        //create some junk cache
        $this->object->saveCache('a', array());
        $this->object->saveCache('b', array());
        $this->object->saveCache('c', array());

        //Reset specific cache
        $this->object->resetCache('a');
        //Assertion: no a cache existed
        $this->assertTrue(!file_exists($this->cacheDir . "/" . $this->environment . "a.cache"));

        //Reset all cache
        $this->object->resetCache();
        $cacheFiles = glob($this->cacheDir . "/" . $this->environment . "*.cache");
        //Assertion: no cache existed
        $this->assertEmpty($cacheFiles);
    }

    public function testInitialize()
    {
        $this->assertFalse($this->object->isInitiated());
        $setting_array = array('foo' => 'bar', 'baz' => 'qux');
        $this->object->initialize($setting_array);
        $this->assertTrue($this->object->isInitiated());
    }

    public function testLoadSettingNoCache()
    {
        $testPlugin = 'riFooBar';

        //Remove cache folder if existed
//        if (file_exists($this->object->getCacheRoot())) {
//            $this->delete_directory($this->object->getCacheRoot());
//        }

        $this->object->load($testPlugin);

        $this->assertEquals('plugins\Test\Controller\TestController::indexAction', $this->object->get('riFooBar.routes.test.defaults._controller'));
        $this->assertTrue($this->object->get('riFooBar.zencart_fallback'));

        $arr = array(1, 2, 3, 4);
        $this->assertEquals($arr, $this->object->get('riFooBar.test_arr'));
        $this->assertEquals('test', $this->object->get('riFooBar.test'));
    }

    public function testLoadFile()
    {
        $testPlugin = 'foobar';

        $this->object->set($testPlugin, ($this->object->loadFile('', __DIR__ . '/Fixtures/appDir/exceptions/', 'config_test_load.yml')));

        $this->assertEquals('foo bar baz qux', $this->object->get('foobar.test'));
    }

    public function testLoadTheme()
    {
        $this->object->loadTheme('frontend', __DIR__ . '/Fixtures/appDir/config');

        //Assertion
        $this->assertTrue((bool)$this->object->get('theme.is_zepluf_theme'));
        $this->assertEquals('two_column_left.php', $this->object->get('theme.layouts.category'));

        //Reset cache
        $this->object->resetCache();
    }

    public function testSaveLocal()
    {
        //Load local setting file
        $settings = $this->object->loadFile('plugins', $this->configDir, '/plugins_' . $this->environment . '.yml');

        //Save to local
        $this->object->saveLocal($this->configDir . '/local.yml', $settings);

        //Reload local setting file
        $this->object->set('local', ($this->object->loadFile('', $this->configDir . '/', 'local.yml')));

        //Assertion
        $this->assertFalse($this->object->get('local.rifoo.cache'));
    }


    public function testSaveCache()
    {
        //Load setting file first
        $local_config = $this->object->loadFile('plugins', $this->configDir, '/plugins_' . $this->environment . '.yml');

        //Save cache
        $this->object->saveCache('plugins', $local_config);

        $cache_content = @file_get_contents($this->cacheDir . "/" . $this->environment . '/plugins.cache');

        //Assertion
        $this->assertEquals($cache_content, serialize($local_config));

        //Reset cache
        $this->object->resetCache();
    }

    public function testLoadCache()
    {
        //Load setting file first
        $local_config = $this->object->loadFile('plugins', $this->configDir, '/plugins_' . $this->environment . '.yml');
        //Save cache...
        $this->object->saveCache('plugins', $local_config);
        //...then load cache
        $settings = $this->object->loadCache('plugins');

        //Assertion
        $this->assertEquals($local_config, $settings);

        //Reset cache
        $this->object->resetCache();
    }

    public function tearDown()
    {
        unset($this->object);
    }
}
