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

        if($container->hasParameter("sys")) {
            $sysConfig = $container->getParameter("sys");

            // load all plugins routes
            if(isset($sysConfig["activated"]) && is_array($sysConfig["activated"])) {
                foreach ($sysConfig["activated"] as $plugin) {
                    $plugin = basename($plugin);

                    // only for activated plugin
                    $plugin_path = $pluginsDir . '/' . $plugin . '/Resources/config/';

                    if (file_exists($plugin_path . 'services.yml')) {
                        $ymlLoader = new YamlFileLoader($container, new FileLocator($plugin_path));
                        $ymlLoader->load('services.yml');
                    }
                }
            }
        }

        // register core services for all available plugins
        foreach(glob($pluginsDir . '/*', GLOB_ONLYDIR) as $plugin_path)
        {
            $plugin_name = basename($plugin_path);
            // register the plugin's core class
            $plugin_class = ucfirst($plugin_name);
            if (file_exists($plugin_path . '/' . $plugin_class . '.php')) {

                $container->setDefinition($plugin_class, new Definition(
                    'plugins\\' . $plugin_name . '\\' . $plugin_class,
                    array(
                        new Reference('database_patcher'),
                        new Reference('event_dispatcher')
                    )
                ));
            }
        }

        // register payment configurations
        $this->registerPaymentConfiguration(array(), $container, $loader);

        // register shipment configurations
        $this->registerShipmentConfiguration(array(), $container, $loader);
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($container->getParameter('kernel.debug'));
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'store';
    }

    /**
     * Loads the payment configuration.
     *
     * @param array         $config A proxy configuration array
     * @param XmlFileLoader $loader An XmlFileLoader instance
     */
    private function registerPaymentConfiguration(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('payment.xml');
    }

    /**
     * Loads the shipment configuration.
     *
     * @param array         $config A proxy configuration array
     * @param XmlFileLoader $loader An XmlFileLoader instance
     */
    private function registerShipmentConfiguration(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('shipment.xml');
    }
}
