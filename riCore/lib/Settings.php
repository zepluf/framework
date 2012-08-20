<?php
namespace plugins\riCore;

use Symfony\Component\Yaml\Yaml;
use plugins\riPlugin\Plugin;

class Settings extends ParameterBag{

    private $is_initiated = false,
    $cache_folder;

    public function __construct(){
        $this->cache_folder = __DIR__ . '/../../../cache/riPlugin/';
        Yaml::enablePhpParsing();
    }

    public function initialize($settings){
        $this->_parameters = $settings;
        $this->is_initiated = true; 
    }

    /**
     * check if the settings are already loaded
     * @return bool
     */
    public function isInitiated(){
        return $this->is_initiated;
    }

    /**
     * reload all settings
     */
    public function reload(){
        // reload the framework settings
        $framework_settings = $this->load('framework', __DIR__ . '/');
        if(is_array($framework_settings['backend']['preload'])) Plugin::load($framework_settings['backend']['preload']);
        if(is_array($framework_settings['frontend']['preload'])) Plugin::load($framework_settings['frontend']['preload']);
        $this->loadTheme();
    }

    /**
     * Load settings from yaml files, load local settings as well
     * @param string $path
     * @param string $file
     */
    public function load($root, $config_path, $file = 'settings.yaml'){
        $settings = array();
        if(file_exists($config_path . $file))
            $settings = Yaml::parse($config_path . $file);

        if(file_exists($config_path . 'local.yaml')){
            $local = (array)Yaml::parse($config_path . 'local.yaml');
            $settings = empty($settings) ? $local : arrayMergeWithReplace($settings, $local);
        }

        $this->set($root, $settings);
        if(isset($settings['global'])) $this->set('global', $settings['global'], true);

        return $settings;
    }

    /**
     * save the settings
     * @param string $plugin
     * @param array $settings
     */
    public function saveLocal($plugin = 'framework', $settings = array()){

        if($plugin == 'framework'){
            $config_path = __DIR__ .'/../../';
        }
        else
            $config_path = __DIR__ .'/../../' . $plugin . '/config/';

        if(empty($settings)){
            $all_settings = $this->get($plugin);

            $default_settings = Yaml::parse(__DIR__ .'/../../settings.yaml');

            $settings = Plugin::get('riUtility.Collection')->multiArrayDiff($all_settings, $default_settings);
        }

        // put into local.yaml
        @file_put_contents($config_path . 'local.yaml', Yaml::dump($settings));
    }

    /**
     * This function will load the settings of the current theme then cache it
     */
    public function loadTheme(){
        // we need to load theme settings

        $theme_settings = $this->load('theme', __DIR__ . '/../../../' . DIR_WS_TEMPLATE, 'theme.yaml');

        // now we need to also allow theme settings to overwrite the plugins settings
        $settings = $this->loadCache('frontend', false, true);

        $settings['theme'] = $theme_settings;

        foreach($theme_settings as $plugin => $plugin_theme_settings){
            if(!empty($settings)){
                if(Plugin::isActivated($plugin)){
                    $settings[$plugin] = empty($settings[$plugin]) ? $plugin_theme_settings : arrayMergeWithReplace($settings[$plugin], $plugin_theme_settings);
                }
            }
        }
        $this->saveCache('frontend', $settings);
    }

    /**
     *
     * load settings from cache file ...
     */
    public function loadCache($cache_file, $init = true, $return = false){
        if(file_exists($this->cache_folder . $cache_file . '.cache')){
            $settings = unserialize(file_get_contents($this->cache_folder . $cache_file . '.cache'));
            if($init) $this->initialize($settings);
            if($return) return $settings;
            else true;
        }
        return false;
    }

    /**
     *
     * save settings into cache file ...
     */
    public function saveCache($cache_file, $settings = null){
        if($settings == null) $settings = $this->get();
        Plugin::get('riUtility.File')->write($this->cache_folder . $cache_file . '.cache', serialize($settings));
    }

    /**
     *
     * delete all cache files
     */
    public function resetCache(){
        $cache_files = glob($this->cache_folder."*.cache");

        if($cache_files !== false)
            foreach ($cache_files as $file) {
                @unlink($file);
            }
    }
}