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
class TemplateLoader extends BaseLoader
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

    protected $type = "templates";

    public function __construct($kernel)
    {

        $subEnvironment = $kernel->getContainer()->get('environment')->getSubEnvironment();

        $this->templatePathPatterns = array(
            // look in the current template first
            $kernel->getContainer()->getParameter('store.'.$subEnvironment.'.templates_dir') . '/' .
                $kernel->getContainer()->get('environment')->getTemplate() .
                '/%path%/%name%.%format%.%engine%',

            $kernel->getContainer()->getParameter('store.'.$subEnvironment.'.templates_dir') . '/' .
                '/template_default/%path%/%name%.%format%.%engine%'
        );
    }
}