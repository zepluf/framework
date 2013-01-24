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
use Zepluf\Bundle\StoreBundle\Settings;

/**
 * Generates the router matcher and generator classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SettingsCacheWarmer implements CacheWarmerInterface
{
    /**
     * the settings service
     *
     * @var \Zepluf\Bundle\StoreBundle\Settings
     */
    protected $settings;

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
    public function __construct(Settings $settings, $frontendTemplateDir, $backendTemplateDir)
    {
        $this->settings = $settings;
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
