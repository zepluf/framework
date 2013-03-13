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

use Symfony\Component\Templating\Storage\Storage;
use Symfony\Component\Templating\Storage\FileStorage;
use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * template loader class
 */
class PluginLoader extends BaseLoader
{

    /**
     * template array
     *
     * @var array
     */
    public $templates = array();

    /**
     * @var array
     */
    protected $kernel;

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
        if ("plugins" == $template->get("type")) {
            $templatePathPatterns = $this->templatePathPatterns;
            $templatePathPatterns[] = $this->kernel->getContainer()->getParameter('kernel.root_dir') . '/plugins/%plugin%/Resources/views/%path%/%name%.%format%.%engine%';

            return $this->locate($template, $templatePathPatterns);
        }

        return false;
    }
}