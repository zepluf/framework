<?php
/**
 * Created by RubikIntegration Team.
 * Date: 12/22/12
 * Time: 6:45 PM
 * Question? Come to our website at http://rubikintegration.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Zepluf\Bundle\StoreBundle\Tests;

require_once(__DIR__ . "/../../../../../app/AppKernel.php");

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected $_container;

    public function __construct()
    {
        $kernel = new \AppKernel("test", true);
        $kernel->boot();
        $this->_container = $kernel->getContainer();
        parent::__construct();
    }

    protected function get($service)
    {
        return $this->_container->get($service);
    }

    protected function getParameter($parameter)
    {
        return $this->_container->getParameter($parameter);
    }
}