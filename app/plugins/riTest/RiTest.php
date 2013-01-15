<?php
/**
 * Created by RubikIntegration Team.
 * User: vunguyen
 * Date: 6/26/12
 * Time: 5:58 PM
 * Question? Come to our website at http://rubikin.com
 */

namespace plugins\riTest;

use Zepluf\Bundle\StoreBundle\PluginCore;

class RiTest extends PluginCore
{
    public function init()
    {
        // Save a file with some content
        $content = 'init run successfully';
        @file_put_contents($this->container->getParameter('kernel.root_dir') . '/../src/Zepluf/Bundle/StoreBundle/Tests/Fixtures/junks/plugins/test_init_file', $content);
    }

    public function install()
    {
        $content = 'install run successfully';
        if (@file_put_contents($this->container->getParameter('kernel.root_dir') . '/../src/Zepluf/Bundle/StoreBundle/Tests/Fixtures/junks/plugins/test_install_file', $content)
        ) {
            return true;
        }
    }

    public function uninstall()
    {
        $content = 'uninstall run successfully';
        if (
            @file_put_contents($this->container->getParameter('kernel.root_dir') . '/../src/Zepluf/Bundle/StoreBundle/Tests/Fixtures/junks/plugins/test_uninstall_file', $content)
        ) {
            return true;
        }
    }
}