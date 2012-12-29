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
        $container->addCompilerPass(new TemplatingPass());

        $appDir = $container->getParameter("kernel.root_dir");
        $pluginsDir = $appDir . '/plugins';

        if (file_exists($sys_file = $appDir . '/config/sys_' . $container->getParameter("kernel.environment") . '.yml')) {
            $sysConfig = Yaml::parse($sys_file);

            $container->setParameter("sys_config", $sysConfig);

            foreach ($sysConfig["activated"] as $plugin) {
                //
                if(is_dir($pluginsDir .  '/' . $plugin . '/DependencyInjection/Compiler')) {
                    foreach (glob($pluginsDir . '/' . $plugin . '/DependencyInjection/Compiler/*Pass.php', GLOB_NOSORT) as $pass) {
                        $class = 'plugins\\' . $plugin . '\DependencyInjection\Compiler\\' . (basename($pass, ".php"));
                        $container->addCompilerPass(new $class());
                    }
                }
            }
        }
    }

    public function getParent()
    {
        //return 'FrameworkBundle';
    }
}
