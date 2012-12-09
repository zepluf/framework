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

use Symfony\Component\Yaml\Yaml;
use plugins\riPlugin\Plugin;

/**
 * settings class which store all plugin's settings
 */
class Settings extends ParameterBag
{

    /**
     * is the settings inited?
     *
     * @var bool
     */
    private $is_initiated = false;

    /**
     * cache folder path?
     *
     * @var string
     */
    private $cache_folder;

    /**
     * @var
     */
    private $pluginsDir;

    /**
     * @var
     */
    private $configDir;

    /**
     * init
     */
    public function __construct($configDir, $cacheDir, $pluginsDir)
    {
        $this->configDir = $configDir . '/';
        $this->pluginsDir = $pluginsDir . '/';
        $this->cache_root_folder = $cacheDir . '/';
        $this->cache_folder = $this->cache_root_folder . 'ZePLUF/';

        Yaml::enablePhpParsing();
    }

    /**
     * checks if the cache folder is writable
     *
     * @return bool
     */
    public function preCheck()
    {
        return is_writable($this->cache_root_folder);
    }

    /**
     * gets the cache root folder
     *
     * @return string
     */
    public function getCacheRoot()
    {
        return $this->cache_root_folder;
    }

    /**
     * inits the settings with an input array
     *
     * @param $settings
     */
    public function initialize($settings)
    {
        $this->_parameters = $settings;
        $this->is_initiated = true;
    }

    /**
     * checks if the init settings are already loaded
     *
     * @return bool
     */
    public function isInitiated()
    {
        return $this->is_initiated;
    }

    /**
     * reloads all settings
     */
    public function reload()
    {
        // reload the framework settings
        $framework_settings = $this->load('framework', $this->configDir);
        if (is_array($framework_settings['backend']['preload'])) Plugin::loadPlugin($framework_settings['backend']['preload']);
        if (is_array($framework_settings['frontend']['preload'])) Plugin::loadPlugin($framework_settings['frontend']['preload']);
        $this->loadTheme('frontend');
    }

    /**
     * loads settings from yaml files, load local settings as well
     *
     * @param $root
     * @param string $config_path
     * @param string $file
     * @return array|bool|mixed
     */
    public function load($root, $config_path = '', $file = 'config.yml')
    {
        if (($settings = $this->loadCache($root)) === false) {
            $settings = array();

            if (empty($config_path)) {
                $config_path = $this->pluginsDir . $root . '/Resources/config/';
            }

            if (file_exists($config_path . $file)) {
                $settings = Yaml::parse($config_path . $file);
            }

            //$this->saveCache($root, $settings);
        }

        $this->set($root, $settings);

        return $settings;
    }

    /**
     * loads settings directly from a file
     *
     * @param $root
     * @param string $config_path
     * @param string $file
     * @return array
     */
    public function loadFile($root, $config_path = '', $file = 'config.yml')
    {

        $settings = array();

        if (empty($config_path)) {
            $config_path = realpath($this->pluginsDir . $root . '/Resources/config') . '/';
        }

        if (file_exists($config_path . $file))
            $settings = Yaml::parse($config_path . $file);

        return $settings;
    }

    /**
     * loads the theme's settings
     *
     * @param string $env
     * @param string $config_path
     * @return array|bool|mixed
     */
    public function loadTheme($env = 'frontend', $config_path = '')
    {
        if (($settings = $this->loadCache('theme')) === false) {
            $settings = array();

            if (empty($config_path)) {
                return $settings;
            }

            if (file_exists($config_path . 'theme.yml'))
                $settings = Yaml::parse($config_path . 'theme.yml');

//            if (file_exists($config_path . 'local.yaml')) {
//                $local = (array)Yaml::parse($config_path . 'local.yaml');
//                $settings = empty($settings) ? $local : arrayMergeWithReplace($settings, $local);
//            }

            $this->saveCache('theme', $settings);
        }

        // a bit hacky here, but we want the theme global to be set specifically to the correct env
        if (isset($settings['global'])) $this->set('global.' . $env, $settings['global'], true);

        // and we also want to override plugin settings
        // a hack to let theme's settings to always override plugins'
        if (isset($settings['plugins']) && is_array($settings['plugins']))
            foreach ($settings['plugins'] as $plugin => $plugin_settings)
                $this->set($plugin, $plugin_settings, true);

        $this->set('theme', $settings);

        return $settings;
    }

    /**
     * saves the local settings
     *
     * @param string $plugin
     * @param array $settings
     */
    public function saveLocal($path, $settings = array())
    {
        // put into local.yaml
        @file_put_contents($path, Yaml::dump($settings));
    }

    /**
     * loads settings from cache file ...
     *
     * @param $root
     * @return bool|mixed
     */
    public function loadCache($root)
    {
        if (file_exists($this->cache_folder . $root . '.cache')) {
            $settings = unserialize(@file_get_contents($this->cache_folder . $root . '.cache'));
            return $settings;
        }
        return false;
    }

    /**
     * saves settings into cache file ...
     *
     * @param $cache_file
     * @param null $settings
     * @return int
     */
    public function saveCache($root, $settings = null)
    {
        riMkDir($this->cache_folder);
        return @file_put_contents($this->cache_folder . $root . '.cache', serialize($settings));
    }


    /**
     * deletes all cache files
     *
     * @param string $root
     */
    public function resetCache($root = '')
    {
        if (!empty($root)) @unlink($this->cache_folder . $root . '.cache');
        else {
            $cache_files = glob($this->cache_folder . "*.cache");

            if ($cache_files !== false)
                foreach ($cache_files as $file) {
                    @unlink($file);
                }
        }
    }
}