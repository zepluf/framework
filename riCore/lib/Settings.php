<?php
namespace plugins\riCore;

use Symfony\Component\Yaml\Yaml;
use plugins\riPlugin\Plugin;

class Settings extends ParameterBag{

    private $is_initiated = false,
    $cache_folder;

    public function __construct(){
        $this->cache_root_folder =  realpath(__DIR__ . '/../../../cache') . '/';
        $this->cache_folder = $this->cache_root_folder . 'ZePLUF/';
        Yaml::enablePhpParsing();
    }

    /**
     * @return bool
     */
    public function preCheck(){
        return is_writable($this->cache_root_folder);
    }

    /**
     * @return string
     */
    public function getCacheRoot(){
        return $this->cache_root_folder;
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
        $this->loadTheme('frontend');
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
                $config_path = realpath(__DIR__.'/../../'.$root.'/config') . '/';
            }

            if(file_exists($config_path . $file))
                $settings = Yaml::parse($config_path . $file);

            if($file != 'local.yaml' && file_exists($config_path . 'local.yaml')){
                $local = (array)Yaml::parse($config_path . 'local.yaml');
                $settings = empty($settings) ? $local : arrayMergeWithReplace($settings, $local);
            }

            $this->saveCache($root, $settings);
        }

        // global settings
        if(isset($settings['global'])) $this->set('global', $settings['global'], true);

        $this->set($root, $settings);

        return $settings;
    }

    public function loadFile($root, $config_path = '', $file = 'settings.yaml'){

        $settings = array();

        if(empty($config_path)){
            $config_path = realpath(__DIR__.'/../../'.$root.'/config') . '/';
        }

        if(file_exists($config_path . $file))
            $settings = Yaml::parse($config_path . $file);

        return $settings;
    }

    public function loadTheme($env = 'frontend', $config_path = ''){
        if(($settings = $this->loadCache('theme')) === false){
            $settings = array();

            if(empty($config_path)){
                return $settings;
            }

            if(file_exists($config_path . 'theme.yaml'))
                $settings = Yaml::parse($config_path . 'theme.yaml');

            if(file_exists($config_path . 'local.yaml')){
                $local = (array)Yaml::parse($config_path . 'local.yaml');
                $settings = empty($settings) ? $local : arrayMergeWithReplace($settings, $local);
            }

            $this->saveCache('theme', $settings);
        }

        // a bit hacky here, but we want the theme global to be set specifically to the correct env
        if(isset($settings['global'])) $this->set('global.'.$env, $settings['global'], true);

        // and we also want to override plugin settings
        // a hack to let theme's settings to always override plugins'
        if(isset($settings['plugins']) && is_array($settings['plugins']))
            foreach($settings['plugins'] as $plugin => $plugin_settings)
                $this->set($plugin, $plugin_settings, true);

        $this->set('theme', $settings);

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