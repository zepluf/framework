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

/**
 * Settings class which store all plugin's settings
 */
class Settings extends ParameterBag
{

    /**
     * Is the settings initiated?
     *
     * @var bool
     */
    private $is_initiated = false;

    /**
     * Cache folder path?
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
     * @var string
     */
    private $environment;

    /**
     * Constructor
     */
    public function __construct($configDir, $cacheDir, $pluginsDir, $environment)
    {
        $this->configDir = $configDir . '/';
        $this->pluginsDir = $pluginsDir . '/';
        $this->cache_root_folder = $cacheDir . '/';
        $this->cache_folder = $this->cache_root_folder . $environment . '/';
    }

    /**
     * Checks if the cache folder is writable
     *
     * @return bool
     */
    public function preCheck()
    {
        return is_writable($this->cache_root_folder);
    }

    /**
     * Gets the cache root folder
     *
     * @return string
     */
    public function getCacheRoot()
    {
        return $this->cache_root_folder;
    }

    /**
     * Init the settings with an input array
     *
     * @param $settings
     */
    public function initialize($settings)
    {
        $this->_parameters = $settings;
        $this->is_initiated = true;
    }

    /**
     * Checks if the init settings are already loaded
     *
     * @return bool
     */
    public function isInitiated()
    {
        return $this->is_initiated;
    }

    /**
     * Reloads all settings
     */
    public function reload($pluginService)
    {
        // reload the framework settings
        $framework_settings = $this->load('framework', $this->configDir);
        if (is_array($framework_settings['backend']['preload'])) $pluginService->loadPlugin($framework_settings['backend']['preload']);
        if (is_array($framework_settings['frontend']['preload'])) $pluginService->loadPlugin($framework_settings['frontend']['preload']);
        $this->loadTheme('frontend');
    }

    /**
     * Loads settings from yml files, load local settings as well
     *
     * @param $root
     * @param string $config_path
     * @param string $file
     * @return array|bool|mixed Return setting array parsed from yml file
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

        }

        $this->set($root, $settings);

        return $settings;
    }

    /**
     * Loads settings directly from a file
     *
     * @param $root
     * @param string $config_path
     * @param string $file
     * @return array Return setting array parsed from yml file
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
     * Loads the theme's settings
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

            if (file_exists($config_file = $config_path . '/' . 'theme.yml')) {
                $settings = Yaml::parse($config_file);
            }

            $this->saveCache('theme', $settings);
        }

        // and we also want to override plugin settings
        // a hack to let theme's settings to always override plugins'
        if (isset($settings['plugins']) && is_array($settings['plugins'])) {
            foreach ($settings['plugins'] as $plugin => $plugin_settings) {
                $this->set('plugins.' . $plugin, $plugin_settings, true);
            }
        }

        $this->set('theme', $settings);

        return $settings;
    }

    /**
     * Saves the local settings
     *
     * @param string $path
     * @param array $settings
     *
     */
    public function saveLocal($path, $settings = array())
    {
        // put into local.yaml
        @file_put_contents($path, Yaml::dump($settings));
    }

    /**
     * Loads settings from cache file ...
     *
     * @param $root
     * @return bool|mixed
     */
    public function loadCache($root)
    {
        if (file_exists($cache_file = $this->cache_folder . $root . '.cache')) {
            $settings = unserialize(@file_get_contents($cache_file));
            return $settings;
        }
        return false;
    }

    /**
     * Saves settings into cache file ...
     * @param $root
     * @param $settings
     * @return int
     */
    public function saveCache($root, $settings = null)
    {
        riMkDir($this->cache_folder);
        return @file_put_contents($this->cache_folder . $root . '.cache', serialize($settings));
    }

    /**
     * Deletes all cache files
     *
     * @param string $root
     */
    public function resetCache($root = '')
    {
        if (!empty($root)) {
            @unlink($this->cache_folder . $root . '.cache');
        } else {
            $cache_files = glob($this->cache_folder . "*.cache");

            if ($cache_files !== false) {
                foreach ($cache_files as $file) {
                    @unlink($file);
                }
            }
        }
    }
}