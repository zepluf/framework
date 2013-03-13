<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace Zepluf\Bundle\StoreBundle\Templating\Loader;

use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * template loader class
 */
class BaseLoader extends FilesystemLoader
{

    /**
     * template array
     *
     * @var array
     */
    public $templates = array();

    protected $type = "type";

    /**
     * @var array
     */
    protected $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;

        $subEnvironment = $kernel->getContainer()->get('environment')->getSubEnvironment();

        $this->templatePathPatterns = array(
            // look in the current template first
            $kernel->getContainer()->getParameter('store.'.$subEnvironment.'.templates_dir') . '/' .
                $kernel->getContainer()->get('environment')->getTemplate() .
                '/%type%/%plugin%/%path%/%name%.%format%.%engine%',

            // look in the default template
            $kernel->getContainer()->getParameter('store.'.$subEnvironment.'.templates_dir') . '/' .
                'template_default/%type%/%plugin%/%path%/%name%.%format%.%engine%'
        );

    }

    /**
     * Loads a template.
     *
     * @param TemplateReferenceInterface $template A template
     *
     * @return Storage|Boolean false if the template cannot be loaded, a Storage instance otherwise
     *
     * @api
     */
    public function load(TemplateReferenceInterface $template)
    {
        if($this->type == $template->get("type")) {
            return $this->locate($template, $this->templatePathPatterns);
        }

        return false;
    }

    /**
     * sets template
     *
     * @param $name
     * @param $content
     */
    public function setTemplate($name, $content)
    {
        $template = new TemplateReference($name, 'php');
        $this->templates[$template->getLogicalName()] = $content;
    }

    protected function locate($template, $paths)
    {
        $file = $template->get('name');

        if (self::isAbsolutePath($file) && is_file($file)) {
            return new FileStorage($file);
        }

        $replacements = array();
        foreach ($template->all() as $key => $value) {
            $replacements['%' . $key . '%'] = $value;
        }

        foreach($paths as $path) {
            if (is_file($file = strtr($path, $replacements)) && is_readable($file)) {
                if (null !== $this->debugger) {
                    $this->debugger->log(sprintf('Loaded template file "%s"', $file));
                }
                return new FileStorage($file);
            }
        }

        if (null !== $this->debugger) {
            $this->debugger->log(sprintf('Failed Loading template file "%s"', $file));
        }

        return false;
    }
}