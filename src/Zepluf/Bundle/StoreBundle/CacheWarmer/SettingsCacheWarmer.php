<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Yaml\Yaml;
use Zepluf\Bundle\StoreBundle\Settings;
use Zepluf\Bundle\StoreBundle\Plugin;

/**
 * Generates the router matcher and generator classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SettingsCacheWarmer implements CacheWarmerInterface
{
    protected $sysSettings;
    /**
     * the settings service
     *
     * @var \Zepluf\Bundle\StoreBundle\Settings
     */
    protected $settings;

    /**
     * @var
     */
    protected $plugins;

    /**
     * @var
     */
    protected $pluginsDir;

    /**
     * @var
     */
    protected $kernelEnvironment;

    /**
     * @var
     */
    protected $kernelConfigDir;

    /**
     * @var string
     */
    protected $frontendTemplateDir;

    /**
     * @var string
     */
    protected $backendTemplateDir;

    /**
     * Constructor.
     *
     * @param RouterInterface $router A Router instance
     */
    public function __construct($sysSettings, Settings $settings, Plugin $plugins, $kernelEnvironment, $kernelConfigDir, $pluginsDir, $frontendTemplateDir, $backendTemplateDir)
    {
        $this->sysSettings = $sysSettings;
        $this->settings = $settings;
        $this->plugins = $plugins;
        $this->kernelEnvironment = $kernelEnvironment;
        $this->kernelConfigDir = $kernelConfigDir;
        $this->pluginsDir = $pluginsDir;
        $this->frontendTemplateDir = $frontendTemplateDir;
        $this->backendTemplateDir = $backendTemplateDir;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        // loads plugins settings
        if (!$this->settings->has('plugins')) {
            // now try to load from all the cache files
            if (($pluginsSettings = $this->settings->loadCache('plugins')) === false) {
                $configs = array();
                // load local plugins settings
                $local_config = Yaml::parse($this->kernelConfigDir . '/plugins_' . $this->kernelEnvironment . '.yml');
                if (!empty($this->sysSettings['activated']) && is_array($this->sysSettings['activated'])) {
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
                    $this->settings->saveCache('plugins', $this->settings->get('plugins'));
                    $pluginsSettings = $this->settings->get('plugins');
                }
            } else {
                $this->settings->set('plugins', $pluginsSettings);
            }
        }

        $this->settings->loadTheme("frontend", $this->frontendTemplateDir);
        // TODO: warmup backend theme's cache as well, if any?
    }

    /**
     * Checks whether this warmer is optional or not.
     *
     * @return Boolean always true
     */
    public function isOptional()
    {
        return false;
    }
}
