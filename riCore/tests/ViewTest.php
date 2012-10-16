<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 10/16/12
 * Time: 6:55 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */
namespace plugins\riCore\tests;

use plugins\riCore\Object;

class ViewTest extends \UnitTestCase
{
    protected $view;

    public function setUp(){
        $this->view = new \plugins\riCore\View(\plugins\riPlugin\Plugin::getContainer());
    }

    public function testSetGet(){
        $this->view->set(array('key' => 'value'));

        $this->assertEqual($this->view->get('key'), 'value');

        // test merging
        $this->view->set(array('key' => 'value2'));
        $this->assertEqual($this->view->get('key'), 'value2');
    }

    public function testFindRenderPathTemplate(){
        // put the template into the current template
        $filePath = DIR_FS_CATALOG . DIR_WS_TEMPLATE . 'templates/tpl_test_template.php';
        $fp = fopen($filePath, 'w');
        fwrite($fp, 'sample template file');

        fclose($fp);

        $filePath = realpath($filePath);

        $this->view->addDefaultPathPattern('template', DIR_FS_CATALOG . DIR_WS_TEMPLATE);

        $renderedPath = $this->view->findRenderPath('templates/tpl_test_template.php');

        $this->assertTrue(is_string($renderedPath));

        $this->assertEqual($filePath, realpath($renderedPath));

        @unlink($filePath);

        // put the file in a plugin path
    }

    public function testFindRenderPathPlugin(){
        // put the template into the current template
        $filePath = DIR_FS_CATALOG . DIR_WS_TEMPLATE . 'plugins/riSample/content/views/test_template.php';
        $fp = fopen($filePath, 'w');
        fwrite($fp, 'sample template file');

        fclose($fp);

        $filePath = realpath($filePath);

        $this->view->addDefaultPathPattern('template', DIR_FS_CATALOG . DIR_WS_TEMPLATE);

        $renderedPath = $this->view->findRenderPath('riSample::test_template.php');

        $this->assertTrue(is_string($renderedPath));

        $this->assertEqual($filePath, realpath($renderedPath));

        @unlink($filePath);

        // put the file in a plugin path
    }
}
