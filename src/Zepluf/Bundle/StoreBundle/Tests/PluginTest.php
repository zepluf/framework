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

        $this->assertFalse($this->settings->get('plugins.ricjloader.settings.cache'));

        $this->assertEquals($local_file, serialize($this->settings->get('plugins')));
    }

    public function testLoadPlugin()
    {
        //Notice: This will init plugin in app/plugins
        try {
            $this->object->loadPlugins($this->_container);
        } catch (\Exception $e) {
            var_dump($e);
        }

        $this->get('event_dispatcher')->addListener(PluginEvents::onPluginLoadEnd, array($this, 'onPluginLoad'));
    }

    public function testGetLoaded()
    {

    }

    public function testGetAvailablePlugins()
    {
        $avail_plugins_array = array('riCjLoader', 'riTest');
        $this->assertEquals($avail_plugins_array, $this->object->getAvailablePlugins());
    }


    public function tearDown()
    {
        unset($this->object);
    }

    public function onPluginLoad(PluginEvents $event)
    {

    }
}
