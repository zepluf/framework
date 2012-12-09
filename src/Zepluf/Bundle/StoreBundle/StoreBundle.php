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
    }

    public function getParent()
    {
        //return 'FrameworkBundle';
    }
}
