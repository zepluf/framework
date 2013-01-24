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

    public function setUp(){
        $this->view = $this->get("view");
        $environment = $this->get("environment");
        $environment->setSubEnvironment("frontend");
        $this->view->setPathPatterns("includes/templates/classic/", $environment);
        $this->defaultTemplateDir = $this->getParameter("store.zencart_dir") . "/includes/templates/template_default";
    }

    public function testSetGet(){
        $this->view->set(array('key' => 'value'));

        $this->assertEquals($this->view->get('key'), 'value');

        // test merging
        $this->view->set(array('key' => 'value2'));
        $this->assertEquals($this->view->get('key'), 'value2');
    }

    public function testFindRenderPathTemplate(){
        // put the template into the current template
        $filePath = $this->defaultTemplateDir . '/templates/tpl_test_template.html.php';
        $fp = fopen($filePath, 'w');
        fwrite($fp, 'sample template file');

        fclose($fp);

        $filePath = realpath($filePath);

        $this->view->addDefaultPathPattern('template', $this->defaultTemplateDir);

        $renderedPath = $this->view->findRenderPath('templates/tpl_test_template.html.php');

        $this->assertTrue(is_string($renderedPath));

        $this->assertEquals($filePath, realpath($renderedPath));

        @unlink($filePath);
    }

    public function testFindRenderPathPlugin(){
        $filePath = $this->getParameter("plugins.root_dir") . '/riSample/Resources/views/test_template.html.php';echo $filePath;
        $fp = fopen($filePath, 'w');
        fwrite($fp, 'sample template file');

        fclose($fp);

        $filePath = realpath($filePath);

        $this->view->addDefaultPathPattern('template', $this->defaultTemplateDir);

        $renderedPath = $this->view->findRenderPath('riSample:test_template.php');

        $this->assertTrue(is_string($renderedPath));

        $this->assertEquals($filePath, realpath($renderedPath));

        // put the template into the plugin overrride
        // now the view should load the overriding file instead

        $filePath2 = $this->getParameter("plugins.root_dir") . '/riSample/Resources/views/test_template.html.php';
        $fp = fopen($filePath2, 'w');
        fwrite($fp, 'sample template file');

        fclose($fp);

        $filePath2 = realpath($filePath2);

        $renderedPath = $this->view->findRenderPath('riSample:test_template.php');

        $this->assertTrue(is_string($renderedPath));

        $this->assertEquals($filePath2, realpath($renderedPath));

        @unlink($filePath);
        @unlink($filePath2);

    }

    public function testRender(){
        $filePath = $this->defaultTemplateDir . '/templates/tpl_test_template.html.php';
        $fp = fopen($filePath, 'w');
        fwrite($fp, 'sample <?php echo $text?> file');

        fclose($fp);

        $filePath = realpath($filePath);

        $this->view->addDefaultPathPattern('template', $this->defaultTemplateDir);
        $renderedContent = $this->view->render('templates/tpl_test_template.html.php', array('text' => 'template'));

        $this->assertEquals($renderedContent, "\r\n <!-- bof: templates/tpl_test_template.html.php --> \r\n" . "sample template file" . "\r\n <!-- eof: templates/tpl_test_template.html.php --> \r\n");

        @unlink($filePath);
    }
}
