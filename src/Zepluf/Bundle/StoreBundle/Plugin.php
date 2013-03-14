<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace Zepluf\Bundle\StoreBundle;

use Zepluf\Bundle\StoreBundle\PluginEvents;
use Zepluf\Bundle\StoreBundle\Event\PluginEvent;
use Symfony\Component\Yaml\Yaml;

/**
 * core class handling anything related to a plugin
 * also acts as the main service container
 */
class Plugin
{

    /**
     * array of loaded plugins names
     *
     * @var array
     */
    private $loaded = array();

    /**
     * array of plugins info
     *
     * @var array
     */
    private $info = array();

    /**
     * current version
     *
     * @var
     */
    private $version;

    /**
     * @var
     */
    private $settings;

    /**
     * @var
     */
    private $eventDispatcher;

    /**
     * backend or frontend env?
     *
     * @var
     */
    private $subEnv;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var
     */
    private $plugins_settings = null;

    /**
     * @var
     */
    private $sysSettings = null;

    /**
     * @var
     */
    private $appDir;

    /**
     * @var
     */
    private $pluginsDir;

    /**
     * inject dependencies
     *
     * @param $settings
     * @param $event_dispatcher
     * @param $environment
     * @param $appDir
     * @param $pluginsDir
     */
    public function __construct($settings, $sysSettings, $event_dispatcher, $environment, $appDir, $pluginsDir)
    {
        $this->settings = $settings;
        $this->sysSettings = $sysSettings;
        $this->environment = $environment;
        $this->eventDispatcher = $event_dispatcher;
        $this->appDir = $appDir;
        $this->pluginsDir = $pluginsDir;

        // check version
//        if ((int)PROJECT_VERSION_MAJOR > 1 || (int)PROJECT_VERSION_MINOR > 0) {
//            $this->version = PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR;
//        }
    }

    /**
     * Loads all plugins settings from cache, if not available then try to load the setting files
     */
    public function loadPluginsSettings()
    {
        if (!$this->settings->has('plugins')) {
            // now try to load from all the cache files
            if (($this->plugins_settings = $this->settings->loadCache('plugins')) === false) {
                $configs = array();
                // load local plugins settings
                $local_config = Yaml::parse($this->appDir . '/config/plugins_' . $this->environment->getEnvironment() . '.yml');

                if(isset($this->sysSettings['activated']) && is_array($this->sysSettings['activated'])) {
                    foreach ($this->sysSettings['activated'] as $plugin) {
                        if (file_exists($file = $this->pluginsDir . '/' . $plugin . '/Resources/config/config.yml')) {
                            $config = Yaml::parse($file);

                            $plugin_lc_name = strtolower($plugin);
                            // $plugin_uc_name = ucfirst($plugin);

                            if (isset($local_config[$plugin_lc_name])) {
                                $this->settings->set('plugins.' . $plugin_lc_name, arrayMergeWithReplace($config, $local_config[$plugin_lc_name]));
                            } else {
                                $this->settings->set('plugins.' . $plugin_lc_name, $config);
                            }

                        }
                    }
                }

                $this->settings->saveCache('plugins', $this->settings->get('plugins'));
                $this->plugins_settings = $this->settings->get('plugins');
            } else {
                $this->settings->set('plugins', $this->plugins_settings);
            }
        }
    }

    /**
     * Loads all plugins
     * @param $container
     */
    public function loadPlugins($container)
    {
        $this->loadPlugin($container, $this->sysSettings['activated']);

        if ($this->environment->getSubEnvironment() == "frontend") {
            $this->settings->loadTheme('frontend');
        }
    }

    public function loadPlugin($container, $plugins)
    {
        if (!is_array($plugins)) {
            $plugins = array($plugins);
        }

        foreach ($plugins as $plugin) {
            if (!in_array($plugin, $this->loaded)) {

                // load vendor if any

                $plugin_path = $this->pluginsDir . '/' . $plugin . '/';

                if(file_exists($autoload_file = $plugin_path . "vendor/autoload.php")) {
                    require($autoload_file);
                }

                $plugin_name = ucfirst($plugin);
                $plugin_lc_name = strtolower($plugin);

                $config_path = $plugin_path . 'Resources/config/';

                $config_files = glob($config_path . "*.php");

                if ($config_files !== false) {
                    foreach ($config_files as $file) {
                        include($file);
                    }
                }

                // load plugin's settings
                $settings = $this->settings->get('plugins.' . $plugin_lc_name, array());

                // init
                if ($container->has($plugin_name)) {
                    $container->get($plugin_name)->setContainer($container);
                    $container->get($plugin_name)->init();
                }

                // set the dispatcher
                $event = new PluginEvent();

                $this->eventDispatcher->dispatch(PluginEvents::onPluginLoadEnd, $event->setPlugin($plugin)->setSettings($settings));

                $this->loaded[] = $plugin;
            }
        }
    }

    /**
     * Gets the array of loaded plugins
     *
     * @return array
     */
    public function getLoaded()
    {
        return $this->loaded;
    }

    /**
     * Checks if a plugin is loaded
     *
     * @param $plugin
     * @return bool
     */
    public function isLoaded($plugin)
    {
        return in_array($plugin, $this->loaded);
    }

    /**
     * This function will install a plugin
     * It will also call the plugins/pluginfolder/PluginClass->install() method of exists
     *
     * @param $container
     * @param $plugin
     * @return bool
     */
    public function install($container, $plugin)
    {
        $this->loadPlugin($container, $plugin);

        $installed = false;

        if (!isset($this->sysSettings['installed']) || !in_array($plugin, $this->sysSettings['installed'])) {

            // we need to do this because this plugin is not installed yet so the service is not registered
            if ($container->has($plugin)) {
                if ($container->get($plugin)->install()) {
                    // we will put into the load

                    $this->sysSettings['installed'][] = $plugin;

                    $this->saveSysSettings($container->get('utility.file'), $container->get('utility.collection'));

                    $this->resetCache($container->get('utility.file'));

                    $installed = true;
                }
            } else {
                $this->sysSettings['installed'][] = $plugin;

                $this->saveSysSettings($container->get('utility.file'), $container->get('utility.collection'));

                $this->resetCache($container->get('utility.file'));

                $installed = true;
            }
        }

        if ($installed) {
            // move the public files to web folder
            $container->get('utility.file')->xcopy($this->pluginsDir . '/' . $plugin . '/Resources/public', $container->getParameter("web.dir") . '/plugins/' . $plugin);
        }

        return $installed;
    }

    /**
     * This function will uninstall a plugin
     * It will also call the plugins/pluginfolder/PluginClass->uninstall() method of exists
     *
     * @param $container
     * @param $plugin
     * @return bool
     */
    public function uninstall($container, $plugin)
    {
        $this->loadPlugin($container, $plugin);

        $uninstalled = false;

        if (isset($this->sysSettings['installed']) && in_array($plugin, $this->sysSettings['installed'])) {

            // we need to deactivate the plugin first
            if (!$this->deactivate($container, $plugin)) {
                return false;
            }

            // attempt to call the plugin uninstall method
            if ($container->has($plugin)) {
                if (!$container->get($plugin)->uninstall()) {
                    return false;
                }
            }

            // remove from the installed list
            arrayRemoveValue($this->sysSettings['installed'], $plugin);

            $this->saveSysSettings($container->get('utility.file'), $container->get('utility.collection'));

            $this->resetCache($container->get('utility.file'));

            $uninstalled = true;
        }

        if ($uninstalled) {
            // remove all
            $container->get('utility.file')->sureRemoveDir($container->getParameter("web.dir") . '/plugins/' . $plugin, true);
        }

        return $uninstalled;
    }

    /**
     * Checks if the plugin is installed
     *
     * @param $plugin
     * @return bool
     */
    public function isInstalled($plugin)
    {
        return in_array($plugin, $this->sysSettings['installed']);
    }

    /**
     * Get plugin info located in plugin.xml file
     *
     * @param mixed $plugin
     */
    public function info($plugin)
    {
        if (!isset($this->info[$plugin]))
            if (file_exists($file_path = $this->pluginsDir . '/' . $plugin . '/plugin.xml')) {
                $this->info[$plugin] = new \SimpleXMLElement(file_get_contents($file_path));
            }
            else {
                $this->info[$plugin] = false;
            }

        return $this->info[$plugin];
    }

    /**
     * This function will activate a plugin
     * It will also call the plugins/pluginfolder/PluginClass->activate() method of exists
     *
     * @param $container
     * @param $plugin
     * @return bool
     */
    public function activate($container, $plugin)
    {
        if (!in_array($plugin, $this->sysSettings['activated'])) {
            if (!$container->has($plugin) || $container->get($plugin)->activate() !== false) {
                $this->sysSettings['activated'][] = $plugin;

                // we will put into the load
                $info = $this->info($plugin);

                // check dependencies first
                if (isset($info->dependencies->plugins)) {
                    $error = false;
                    foreach ($info->dependencies->plugins->plugin as $dependent_plugin) {
                        if (!$this->isInstalled($dependent_plugin->codename)) {
                            $error = true;
                            $container->get('logs')->err(sprintf('Plugin %s min version %s is required', $dependent_plugin->codename, $dependent_plugin->min));
                        } elseif (!$this->isActivated($dependent_plugin->codename) || compareVersions($info->release, $dependent_plugin->min) == VERSION_LESS) {
                            // we need to check the version
                            $error = true;
                            $container->get('logs')->err(sprintf('Plugin %s min version %s is required', $dependent_plugin->codename, $dependent_plugin->min));
                        }
                    }

                    if ($error) {
                        return false;
                    }
                }

                if ($info->preload->frontend == 'true') {
                    $this->sysSettings['frontend'][] = $plugin;
                }

                if ($info->preload->backend == 'true') {
                    $this->sysSettings['backend'][] = $plugin;
                }

                // set back to settings
                $this->saveSysSettings($container->get('utility.file'), $container->get('utility.collection'));

                // add menu for ZC 1.5.0 >
                if (function_exists('zen_register_admin_page')) {
                    $this->loadPlugin($container, $plugin);
                    if (($menus = $this->settings->get('plugins.' . strtolower($plugin) . '.menu', null)) != null) {
                        foreach ($menus as $menu_key => $sub_menus) {
                            foreach ($sub_menus as $menu) {
                                $id = md5($menu['link']);
                                zen_deregister_admin_pages($id);
                                zen_register_admin_page($id, 'ZEPLUF_NAME_' . $id, 'ZEPLUF_URL_' . $id, '', $menu_key, 'Y', 1);
                            }
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     * This function will deactivate a plugin
     * It will also call the plugins/pluginfolder/PluginClass->deactivate() method of exists
     *
     * @param $container
     * @param $plugin
     * @return bool
     */
    public function deactivate($container, $plugin)
    {
        if (in_array($plugin, $this->sysSettings['activated'])) {
            if (!$container->has($plugin) || $container->get($plugin)->deactivate() !== false) {
                arrayRemoveValue($this->sysSettings['activated'], $plugin);
                arrayRemoveValue($this->sysSettings['frontend'], $plugin);
                arrayRemoveValue($this->sysSettings['backend'], $plugin);

                $this->saveSysSettings($container->get('utility.file'), $container->get('utility.collection'));
                // add menu for ZC 1.5.0 >
                if (function_exists('zen_deregister_admin_pages')) {
                    if (($menus = $this->settings->get("plugins." . $plugin . ".menu", null)) != null) {
                        foreach ($menus as $menu_key => $sub_menus) {
                            foreach ($sub_menus as $menu) {
                                $id = md5($menu['link']);
                                zen_deregister_admin_pages($id);
                            }
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     * Checks if a plugin is activated
     *
     * @param $plugin
     * @return bool
     */
    public function isActivated($plugin)
    {
        return in_array($plugin, $this->sysSettings['activated']);
    }

    /**
     * Gets the current environment
     *
     * @return mixed
     */
    public function getSubEnv()
    {
        return $this->subEnv;
    }

    public function getAvailablePlugins()
    {
        $plugins = array();

        foreach (glob($this->pluginsDir . '/*', GLOB_ONLYDIR) as $plugin) {
            $plugins[] = basename($plugin);
        }

        return $plugins;
    }

    /**
     * Saves settings
     */
    public function saveSysSettings($utilityFile, $collectionUtility, $settings = null)
    {
        if(!empty($settings)) {
            $this->sysSettings = $collectionUtility->arrayMergeWithReplace($this->sysSettings, $settings);
        }
        $this->settings->saveLocal($this->appDir . '/config/sys_' . $this->environment->getEnvironment() . '.yml', $this->sysSettings);
        
        // remove the container cache
        $utilityFile->sureRemoveDir($this->appDir . '/cache/' . $this->environment->getEnvironment());
    }

    /**
     * Resets cache
     *
     * @param $utility_file
     */
    private function resetCache($utility_file)
    {
        $utility_file->sureRemoveDir($this->appDir . '/cache');
    }
}