<?php
/**
 * Created by RubikIntegration Team.
 * User: vunguyen
 * Date: 6/26/12
 * Time: 5:58 PM
 * Question? Come to our website at http://rubikin.com
 */

namespace plugins\riFooBar;

use Zepluf\Bundle\StoreBundle\PluginCore;

class RiFooBar extends PluginCore
{
    public function init()
    {
        // Save a file with some content
        $content = 'RiFooBar init run successfully';

        file_put_contents($this->container->getParameter('kernel.root_dir') . '/../output/test_init_file', $content);
    }

    public function install()
    {
        $content = 'RiFooBar install run successfully';
        if (file_put_contents($this->container->getParameter('kernel.root_dir') . '/../output/test_install_file', $content)
        ) {
            return true;
        }
    }

    public function uninstall()
    {
        $content = 'RiFooBar uninstall run successfully';
        if (
            file_put_contents($this->container->getParameter('kernel.root_dir') . '/../output/test_uninstall_file', $content)
        ) {
            return true;
        }
    }

//    public function activate()
//    {
//        $content = 'RiFooBar activate run successfully';
//        if (file_put_contents($this->container->getParameter('kernel.root_dir') . '/../output/test_activate_file', $content)
//        ) {
//            return true;
//        }
//    }
//
//    public function deactivate()
//    {
//        $content = 'RiFooBar deactivate run successfully';
//        if (file_put_contents($this->container->getParameter('kernel.root_dir') . '/../output/test_deactivate_file', $content)
//        ) {
//            return true;
//        }
//    }
}