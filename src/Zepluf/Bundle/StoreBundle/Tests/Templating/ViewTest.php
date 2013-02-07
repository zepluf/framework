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

namespace Zepluf\Bundle\StoreBundle\Tests\Templating;

use Zepluf\Bundle\StoreBundle\Tests\BaseTestCase;

class ViewTest extends BaseTestCase
{
    protected $view;

    protected $defaultTemplateDir;

    public function setUp()
    {
        $this->get('environment')->setSubEnvironment("frontend");
        $this->view = $this->get("view");
        $environment = $this->get("environment");
        $environment->setSubEnvironment("frontend");
        $this->defaultTemplateDir = $this->getParameter("store.frontend.templates_dir") . "/template_default";
    }

    public function testSetGet()
    {
        $this->view->set(array('key' => 'value'));

        $this->assertEquals($this->view->get('key'), 'value');

        // test merging
        $this->view->set(array('key' => 'value2'));
        $this->assertEquals($this->view->get('key'), 'value2');
    }

    public function testFindRenderPathTemplate()
    {
        // put the template into the current template
        $filePath = $this->defaultTemplateDir . '/templates/tpl_test_template.html.php';
        $fp = fopen($filePath, 'w');
        fwrite($fp, 'sample template file');

        fclose($fp);

        $filePath = realpath($filePath);

        $renderedPath = $this->view->findRenderPath('templates/tpl_test_template.html.php');

        $this->assertTrue(is_string($renderedPath));

        $this->assertEquals($filePath, realpath($renderedPath));

        @unlink($filePath);
    }

    public function testFindRenderPathPlugin()
    {
        $filePath = $this->getParameter("plugins.root_dir") . '/riFooBar/Resources/views/test_template.html.php';
        $fp = fopen($filePath, 'w');
        fwrite($fp, 'sample template file');

        fclose($fp);

        $filePath = realpath($filePath);

        $renderedPath = $this->view->findRenderPath('riFooBar:test_template.html.php');

        $this->assertTrue(is_string($renderedPath));

        $this->assertEquals($filePath, realpath($renderedPath));

        // put the template into the plugin overrride
        // now the view should load the overriding file instead

        $filePath2 = $this->getParameter("plugins.root_dir") . '/riFooBar/Resources/views/test_template.html.php';
        $fp = fopen($filePath2, 'w');
        fwrite($fp, 'sample template file');

        fclose($fp);

        $filePath2 = realpath($filePath2);

        $renderedPath = $this->view->findRenderPath('riFooBar:test_template.html.php');

        $this->assertTrue(is_string($renderedPath));

        $this->assertEquals($filePath2, realpath($renderedPath));

        @unlink($filePath);
        @unlink($filePath2);
    }
}
