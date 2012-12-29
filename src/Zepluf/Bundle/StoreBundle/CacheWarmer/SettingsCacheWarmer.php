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
    protected $settings;

    protected $templateDir;

    /**
     * Constructor.
     *
     * @param RouterInterface $router A Router instance
     */
    public function __construct(Settings $settings, $templateDir)
    {
        $this->settings = $settings;
        $this->templateDir = $templateDir;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $this->settings->loadTheme("frontend", $this->templateDir);
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
