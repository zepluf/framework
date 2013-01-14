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

class PluginTest extends BaseTestCase
{
    protected $object;
    private $configDir;
    private $cacheDir;
    private $pluginDir;
    private $environment;
    private $listenerResult = '';

    protected $settings;

    public static function setUpBeforeClass()
    {
        define('PROJECT_VERSION_MAJOR', '1');
        define('PROJECT_VERSION_MINOR', '5.1');
    }

    public function setUp()
    {
        $appDir = __DIR__ . '/Fixtures/appDir';
        $this->configDir = $appDir . '/config';
        $this->cacheDir = $appDir . '/cache';
        $this->pluginDir = $appDir . '/plugins';

//        $settings = new Settings($this->configDir, $this->cacheDir, $this->pluginDir, $this->env = $this->getParameter('kernel.environment'));

        //Get and set environment
        $this->environment = $this->get('environment');
        $this->environment->setEnvironment($this->getParameter('kernel.environment'));
        $this->environment->setSubEnvironment('frontend');

        $this->settings = new Settings($this->configDir, $this->cacheDir, $this->pluginDir, $this->getParameter('kernel.environment'));

        $this->object = new Plugin($this->settings, $this->get('event_dispatcher'), $this->environment, $appDir, $this->pluginDir);
    }

    public function testLoadSysSettings()
    {
        //Load system setting file
        $this->object->loadSysSettings();

        //Open system setting file
        $local_config = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        //Assertion: Compare system setting file with system setting in Settings service
        $this->assertEquals($local_config, $this->settings->get('sys'));
    }


    public function testLoadPluginSettings()
    {
        $this->settings->resetCache();

        $this->object->loadPluginsSettings();

        $local_file = Yaml::parse($this->cacheDir . '/ZePLUF/plugins_' . $this->environment->getEnvironment() . '.cache');

        $this->assertEquals($local_file, serialize($this->settings->get('plugins')));
    }

    public function testLoadPlugins()
    {
        $this->get('event_dispatcher')->addListener(PluginEvents::onPluginLoadEnd, array($this, 'onPluginLoad'));

        //Notice: This will init plugin in app/plugins
        $this->object->loadPlugins($this->_container);

        //Assertion: getLoader, test event dispatcher
        $this->assertEquals(array('riCjLoader'), $this->object->getLoaded());
        $this->assertEquals("OK", $this->listenerResult);
    }

    public function testLoadPlugin()
    {
        $content = 'init run successfully';
        $this->object->loadPlugin($this->_container, array('riTest'));

        $this->assertEquals($content, file_get_contents(__DIR__ . '/Fixtures/junks/test_init_file'));
    }


    public function testInstall()
    {
        //get and parse system setting file first
        $localConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');
        arrayInsertValue($localConfig['installed'], 'riTest');

        //Install riTest
        $this->object->loadSysSettings();
        $this->object->install($this->_container, 'riTest');

        //get and parse new system setting file

        $newLocalConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        //Assertion 1: Make sure riTest append to settings by compare two setting array
        $this->assertEquals($localConfig, $newLocalConfig);

        //Assertion 2: Make sure public files moved into web dir
        $this->assertFileExists(($this->getParameter('web_dir') . '/plugins/riTest/test_public.css'));

        //Assertion 3: Make sure install code executed
        $this->assertEquals('install run successfully', file_get_contents(__DIR__ . '/Fixtures/junks/test_install_file'));

        //Final assertion
        $this->assertTrue($this->object->isInstalled('riTest'));
    }

    public function testInfo()
    {
        $plugin = 'riTest';
        $info = $this->object->info($plugin);
        $this->assertEquals("RiTest", $info->name);
        $this->assertEquals("RiTest for ZePLUF unit testing", $info->summary);
        $this->assertTrue((bool)$info->preload->frontend);
    }

    public function testActivate()
    {
        global $messageStack;
        $messageStack = $this->getMock('messageStack', array('add_session', 'add'));
        $messageStack->expects($this->once())
            ->method('add_session')
            ->with('messageStackError', sprintf('Plugin %s min version %s is required', 'riTest2', '1.0'), 'error');

        //get and parse system setting file first
        $this->object->loadSysSettings();

        $localConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        $this->assertTrue(!in_array('riTest', $localConfig['activated']));

        $this->object->activate($this->_container, 'riTest');

        $newLocalConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');
        $this->assertTrue(in_array('riTest', $newLocalConfig['activated']));

        //Test Dependencies
    }

    public function testDeactivate()
    {
        //get and parse system setting file first
        $this->object->loadSysSettings();

        $localConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');
        arrayRemoveValue($localConfig['activated'], 'riTest');
        arrayRemoveValue($localConfig['frontend'], 'riTest');
        arrayRemoveValue($localConfig['backend'], 'riTest');

        $this->object->deactivate($this->_container, 'riTest');

        $newLocalConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        $this->assertEquals($localConfig, $newLocalConfig);
    }

    public function testUninstall()
    {
        //get and parse system setting file first
        $localConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');
        arrayRemoveValue($localConfig['installed'], 'riTest');
        arrayRemoveValue($localConfig['activated'], 'riTest');
        arrayRemoveValue($localConfig['backend'], 'riTest');
        arrayRemoveValue($localConfig['frontend'], 'riTest');

        //Uninstall riTest
        $this->object->loadSysSettings();
        $this->object->uninstall($this->_container, 'riTest');

        //get and parse new system setting file

        $newLocalConfig = Yaml::parse($this->configDir . '/sys_' . $this->environment->getEnvironment() . '.yml');

        //Assertion 1: Make sure riTest removed to settings by compare two setting array
        $this->assertEquals($localConfig, $newLocalConfig);

        //Assertion 2: Make sure public files moved into web dir
        $this->assertFileNotExists(($this->getParameter('web_dir') . '/plugins/riTest/test_public.css'));

        //Assertion 3: Make sure install code executed
        $this->assertEquals('uninstall run successfully', file_get_contents(__DIR__ . '/Fixtures/junks/test_uninstall_file'));

        //Final assertion
        $this->assertFalse($this->object->isInstalled('riTest'));
    }


    public function testGetAvailablePlugins()
    {
        $availablePlugins = array('riCjLoader', 'riTest');
        $this->assertEquals($availablePlugins, $this->object->getAvailablePlugins());
    }

    public function onPluginLoad(PluginEvent $event)
    {
        $this->listenerResult = 'OK';
    }

    public function tearDown()
    {
        unset($this->object);

        //Remove junk files
        if (file_exists(__DIR__ . '/Fixtures/test_init_file.txt')) {
            unlink(__DIR__ . '/Fixtures/test_init_file.txt');
        }
    }
}
