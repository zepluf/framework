<?php
namespace plugins\riCore;

use Symfony\Component\Yaml\Yaml;
use plugins\riPlugin\Plugin;

class Settings extends ParameterBag{

    private $is_initiated = false,
    $cache_folder;

    public function __construct(){
        $this->cache_folder = __DIR__ . '/../../../cache/ZePLUF/';
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
    public function load($root, $config_path = '', $file = 'settings.yaml'){
        if(($settings = $this->loadCache($root)) === false){
            $settings = array();

            if(empty($config_path)){
                // a temporary hack for theme settings
                if($this == 'theme') return $settings;

                $config_path = realpath(__DIR__.'/../../'.$root.'/config') . '/';
            }

            if(file_exists($config_path . $file))
                $settings = Yaml::parse($config_path . $file);

            if(file_exists($config_path . 'local.yaml')){
                $local = (array)Yaml::parse($config_path . 'local.yaml');
                $settings = empty($settings) ? $local : arrayMergeWithReplace($settings, $local);
            }

            $this->saveCache($root, $settings);
        }

        // a hack to let theme's settings to always override plugins'
        if($root != 'theme')
            if(($theme_settings = $this->get('theme.' . $root)) != self::DEFAULT_KEY)
                $settings = arrayMergeWithReplace($settings, $theme_settings);

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

            $default_settings = Yaml::parse($config_path . 'settings.yaml');

            $settings = arrayRecursiveDiff($all_settings, $default_settings);
            arrayRecursiveReindex($settings);
        }

        // put into local.yaml
        @file_put_contents($config_path . 'local.yaml', Yaml::dump($settings));

        $this->resetCache($plugin);
    }

    /**
     *
     * load settings from cache file ...
     */
    public function loadCache($root){
        if(file_exists($this->cache_folder . $root . '.cache')){
            $settings = unserialize(@file_get_contents($this->cache_folder . $root . '.cache'));
            return $settings;
        }
        return false;
    }

    /**
     *
     * save settings into cache file ...
     */
    public function saveCache($cache_file, $settings = null){
        riMkDir($this->cache_folder);
        return @file_put_contents($this->cache_folder . $cache_file . '.cache', serialize($settings));
    }

    /**
     * TODO: log
     * delete all cache files
     */
    public function resetCache($root = ''){
        if(!empty($root)) @unlink($this->cache_folder . $root . '.cache');
        else{
            $cache_files = glob($this->cache_folder."*.cache");

            if($cache_files !== false)
                foreach ($cache_files as $file) {
                    @unlink($file);
                }
        }
    }
}