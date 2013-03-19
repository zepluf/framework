<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 10/20/12
 * Time: 9:07 AM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\TemplatingPass;
use Symfony\Component\Yaml\Yaml;
use Zepluf\Bundle\StoreBundle\DependencyInjection\Compiler\ZeplufPass;
use Zepluf\Bundle\StoreBundle\DependencyInjection\Compiler\StorePass;

/**
 * Bundle.
 *
 */
class StoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ZeplufPass());
        $container->addCompilerPass(new StorePass());
        $container->addCompilerPass(new TemplatingPass());
        $container->addCompilerPass(new StorePass());

        // allow plugins to have their own compiler passes
        $appDir = $container->getParameter("kernel.root_dir");
        $pluginsDir = $appDir . '/plugins';

        // copy config files from dist folder
        foreach (glob($appDir . '/config_dist/*', GLOB_NOSORT) as $config_file) {
            $config_filename = basename($config_file);
            if (!file_exists($dest_config_file = $appDir . '/config/' . $config_filename)) {
                copy($config_file, $dest_config_file);
            }
        }

        // load the sys config which store the current plugins installed etc
        if (file_exists($sysFile = $appDir . '/config/sys_' . $container->getParameter("kernel.environment") . '.yml')) {
            $sysConfig = Yaml::parse($sysFile);

            $container->setParameter("sys", $sysConfig);

            if (isset($sysConfig["activated"]) && is_array($sysConfig["activated"])) {
                foreach ($sysConfig["activated"] as $plugin) {
                    //
                    if (is_dir($pluginsDir . '/' . $plugin . '/DependencyInjection/Compiler')) {
                        foreach (glob($pluginsDir . '/' . $plugin . '/DependencyInjection/Compiler/*Pass.php', GLOB_NOSORT) as $pass) {
                            $class = '\\plugins\\' . $plugin . '\DependencyInjection\Compiler\\' . (basename($pass, ".php"));
                            $container->addCompilerPass(new $class());
                        }
                    }
                }
            }
        }

        // save the sys config
        @file_put_contents($sysFile, Yaml::dump($sysConfig));
    }

    public function getParent()
    {
        //return 'FrameworkBundle';
    }
}
