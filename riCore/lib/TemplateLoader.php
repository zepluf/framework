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

namespace plugins\riCore;

use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\TemplateReferenceInterface;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Storage\StringStorage;

/**
 * template loader class
 */
class TemplateLoader extends FilesystemLoader{

    /**
     * template array
     *
     * @var array
     */
    public $templates = array();

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

    /**
     * unshifts path pattern
     *
     * @param $path_pattern
     */
    public function unshiftPathPattern($path_pattern){              
        array_unshift($this->templatePathPatterns, $path_patterns);
    }

    /**
     * pushes path pattern
     *
     * @param $path_pattern
     */
    public function pushPathPattern($path_pattern){              
        $this->templatePathPatterns[] = $path_pattern;
    }

    /**
     * pushes path patterns
     *
     * @param $path_patterns
     */
    public function pushPathPatterns($path_patterns){              
        $this->templatePathPatterns = array_merge($this->templatePathPatterns, $path_patterns);
    }

    /**
     * sets path patterns
     *
     * @param $path_patterns
     */
    public function setPathPatterns($path_patterns){
        $this->templatePathPatterns = $path_patterns;
    }
}