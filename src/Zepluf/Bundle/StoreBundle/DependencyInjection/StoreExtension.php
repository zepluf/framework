<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

/**
 * FrameworkExtension.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jeremy Mikola <jmikola@gmail.com>
 */
class StoreExtension extends Extension
{
    /**
     * Responds to the app.config configuration parameter.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('config.xml');

        $appDir = $container->getParameter("kernel.root_dir");
        $pluginsDir = $appDir . '/plugins';

        $sysConfig = $container->getParameter("sys_config");

        // load all plugins routes
        foreach ($sysConfig["activated"] as $plugin) {
            $plugin = basename($plugin);

            // only for activated plugin
            $plugin_path = $pluginsDir . '/' . $plugin . '/Resources/config/';

            // register the plugin's core class
            $plugin_class = ucfirst($plugin);
            if (file_exists($pluginsDir . '/' . $plugin . '/' . $plugin_class . '.php')) {

                $container->setDefinition($plugin_class, new Definition(
                    'plugins\\' . $plugin . '\\' . $plugin_class,
                    array(
                        new Reference('database_patcher'),
                        new Reference('event_dispatcher')
                    )
                ));
            }

            if (file_exists($plugin_path . 'services.yml')) {
                $ymlLoader = new YamlFileLoader($container, new FileLocator($plugin_path));
                $ymlLoader->load('services.yml');
            }
        }
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($container->getParameter('kernel.debug'));
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'store';
    }
}
