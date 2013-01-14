<?php
/**
 * Created by RubikIntegration Team.
 * User: vunguyen
 * Date: 6/26/12
 * Time: 5:58 PM
 * Question? Come to our website at http://rubikin.com
 */

namespace Zepluf\Bundle\StoreBundle\Tests\Fixtures\plugins\riTest;

use Zepluf\Bundle\StoreBundle\PluginCore;
use Zepluf\Bundle\StoreBundle\Event\CoreEvent;
use Zepluf\Bundle\StoreBundle\Events;

class RiTest extends PluginCore
{
    public function init()
    {
        die("A");
    }

    public function install()
    {
        return $this->container->get('database_patcher')->executeSqlFile(file(__DIR__ . '/install/sql/install.sql'));
    }

    public function uninstall()
    {
        return $this->container->get('database_patcher')->executeSqlFile(file(__DIR__ . '/install/sql/uninstall.sql'));
    }
}