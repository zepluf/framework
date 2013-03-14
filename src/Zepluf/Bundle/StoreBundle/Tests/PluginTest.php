<?php
/**
 * Created by RubikIntegration Team.
 *
 * User: Tuan Nguyen
 * Date: 1/11/13
 * Time: 2:12 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Tests;

use \Zepluf\Bundle\StoreBundle\Plugin;
use Symfony\Component\Yaml\Yaml;
use \Zepluf\Bundle\StoreBundle\Settings;
use Zepluf\Bundle\StoreBundle\PluginEvents;
use Zepluf\Bundle\StoreBundle\Event\PluginEvent;
use Symfony\Component\ClassLoader\UniversalClassLoader;

class PluginTest extends BaseTestCase
{
    protected $object;
    protected $appDir;
    protected $configDir;
    protected $cacheDir;
    protected $pluginDir;
    protected $environment;
    protected $listenerResult = '';
    protected $settings;

    public static function setUpBeforeClass()
    {
        $loader = new UniversalClassLoader();
        $loader->registerNamespace('plugins\riFooBar', __DIR__ . '/Fixtures/appDir/');
        $loader->register();
    }

    public function setUp()
    {
        $this->appDir = __DIR__ . '/Fixtures/appDir';
        $this->configDir = $this->appDir . '/config';
        $this->cacheDir = $this->appDir . '/cache';
        $this->pluginDir = $this->appDir . '/plugins';

        //Get and set environment
        $this->environment = new TestEnvironment();

        //Get settings
        $this->settings = new Settings($this->configDir, $this->cacheDir, $this->pluginDir, $this->environment->getEnvironment());

        //Sys Settings
        if (file_exists($sysFile = $this->appDir . '/config/sys_' . $this->environment->getEnvironment() . '.yml')) {
            $sysConfig = Yaml::parse($sysFile);
        }

        $this->object = new Plugin($this->settings, $sysConfig, $this->get('event_dispatcher'), $this->environment, $this->appDir, $this->pluginDir);
    }

    public function testLoadPluginSettingsNoCache()
    {
        $this->settings->resetCache();
        $this->object->loadPluginsSettings();
        $local_file = file_get_contents($this->cacheDir . '/' . $this->environment->getEnvironment() . '/plugins.cache');
        $this->assertEquals($local_file, serialize($this->settings->get('plugins')));
    }

    public function testLoadPlugins()
    {
        $oldConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        $this->get('event_dispatcher')->addListener(PluginEvents::onPluginLoadEnd, array($this, 'onPluginLoad'));

        $this->object->activate($this->_container, 'riFooBar');

        //Notice: This will init plugin in app/plugins
        $this->object->loadPlugins($this->_container);

        //Assertion: getLoader, test event dispatcher
        $this->assertEquals(array('riFoo', 'riFooBar'), $this->object->getLoaded());
        $this->assertEquals("OK", $this->listenerResult);

        //reset System setting file
        $this->settings->saveLocal($this->configDir . '/sys_test.yml', $oldConfig);
    }

    public function testLoadPlugin()
    {
        $content = 'RiFooBar init run successfully';

        $this->object->loadPlugin($this->_container, array('riFooBar'));

        $this->assertEquals($content, file_get_contents(__DIR__ . '/Fixtures/output/test_init_file'));
    }

    public function testInfo()
    {
        $plugin = 'riFooBar';
        $info = $this->object->info($plugin);
        $this->assertEquals("RiFooBar", $info->name);
        $this->assertEquals("Sample plugin for ZePLUF unit testing", $info->summary);
        $this->assertTrue((bool)$info->preload->frontend);
    }

    public function testInstall()
    {
        //get and parse system setting file first
        $oldConfig = $localConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        arrayInsertValue($localConfig['installed'], 'riFooBar');

        //Install riFooBar
        $this->object->install($this->_container, 'riFooBar');

        //get and parse new system setting file
        $newLocalConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        //Assertion 1: Make sure riTest append to settings by compare two setting array
        $this->assertEquals($localConfig, $newLocalConfig);

        //Assertion 2: Make sure public files moved into web dir
        $this->assertFileExists(($this->getParameter('web.dir') . '/plugins/riFooBar/css/foo.css'));

        //Assertion 3: Make sure install code executed
        $this->assertEquals('RiFooBar install run successfully', file_get_contents(__DIR__ . '/Fixtures/output/test_install_file'));

        //Final assertion
        $this->assertTrue($this->object->isInstalled('riFooBar'));

        //reset System setting file
//        $this->settings->saveLocal($this->configDir . '/sys_test.yml', $oldConfig);
    }

    public function testActivate()
    {
//        global $messageStack;
        // Call if activation fail.
//        $messageStack = $this->getMock('messageStack', array('add_session', 'add'));
//        $messageStack->expects($this->once())
//            ->method('add_session')
//            ->with('messageStackError', sprintf('Plugin %s min version %s is required', 'riTest2', '1.0'), 'error');

        //get and parse system setting file first

        $oldConfig = $localConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        $this->assertTrue(!in_array('riFooBar', $localConfig['activated']));

        //If there are dependencies in config, this case will be fail
        $this->object->activate($this->_container, 'riFooBar');

        $newLocalConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');
        $this->assertTrue(in_array('riFooBar', $newLocalConfig['activated']));

        //reset System setting file
        $this->settings->saveLocal($this->configDir . '/sys_test.yml', $oldConfig);
    }


    public function testDeactivate()
    {
        $localConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');
        arrayRemoveValue($localConfig['activated'], 'riFooBar');
        arrayRemoveValue($localConfig['frontend'], 'riFooBar');
        arrayRemoveValue($localConfig['backend'], 'riFooBar');

        $this->object->deactivate($this->_container, 'riFooBar');

        $newLocalConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        $this->assertEquals($localConfig, $newLocalConfig);
    }

    public function testUninstall()
    {
        //get and parse system setting file first
        $localConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');
        arrayRemoveValue($localConfig['installed'], 'riFooBar');

        //Uninstall riTest
        $this->object->uninstall($this->_container, 'riFooBar');

        //get and parse new system setting file
        $newLocalConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        //Assertion 1: Make sure riTest removed to settings by compare two setting array
        $this->assertEquals($localConfig, $newLocalConfig);

        //Assertion 2: Make sure public files moved into web dir
        $this->assertFileNotExists(($this->getParameter('web.dir') . '/plugins/riFooBar/foo.css'));

        //Assertion 3: Make sure install code executed
        $this->assertEquals('RiFooBar uninstall run successfully', file_get_contents(__DIR__ . '/Fixtures/output/test_uninstall_file'));

        //Final assertion
        $this->assertFalse($this->object->isInstalled('riFooBar'));
    }

    public function testGetAvailablePlugins()
    {
        $availablePlugins = array('riFoo', 'riFooBar');
        $this->assertEquals($availablePlugins, $this->object->getAvailablePlugins());
    }

    public function onPluginLoad(PluginEvent $event)
    {
        $this->listenerResult = 'OK';
    }

    public function tearDown()
    {
        unset($this->object);
    }
}
