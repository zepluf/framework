<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Config\Resource\DirectoryResource;
use Symfony\Component\Finder\Finder;
/**
 * Registers the Twig exception listener if Twig is registered as a templating engine.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ZeplufPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if($container->hasParameter("sys")) {
            $sysConfig = $container->getParameter("sys");
            $pluginsDir = $container->getParameter("kernel.root_dir") . '/plugins';

            if(isset($sysConfig["activated"]) && is_array($sysConfig["activated"])) {
                foreach ($sysConfig["activated"] as $plugin) {
                    $plugin = basename($plugin);
                    // load language files
                    if (is_dir($dir = $pluginsDir . '/' . $plugin . '/Resources/translations')) {
                        $translator = $container->findDefinition('translator.default');
                        // Discover translation directories
                        $dirs = array($dir);

                        // Register translation resources
                        if ($dirs) {
                            foreach ($dirs as $dir) {
                                $container->addResource(new DirectoryResource($dir));
                            }
                            $finder = Finder::create()
                                ->files()
                                ->filter(function (\SplFileInfo $file) {
                                return 2 === substr_count($file->getBasename(), '.') && preg_match('/\.\w+$/', $file->getBasename());
                            })
                                ->in($dirs);

                            foreach ($finder as $file) {
                                // filename is domain.locale.format
                                list($domain, $locale, $format) = explode('.', $file->getBasename(), 3);
                                $translator->addMethodCall('addResource', array($format, (string)$file, $locale, $domain));
                            }
                        }
                    }
                }
            }
        }
    }
}