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
class TemplateLoader extends FilesystemLoader
{

    /**
     * template array
     *
     * @var array
     */
    public $templates = array();

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
        $file = $template->get('name');

        if (self::isAbsolutePath($file) && is_file($file)) {
            return new FileStorage($file);
        }

        $replacements = array();
        foreach ($template->all() as $key => $value) {
            $replacements['%' . $key . '%'] = $value;
        }

        // customize the path
        $logs = array();
        foreach ($this->templatePathPatterns as $templatePathPattern) {
            // we allow normal template with no "format" in the name
            if($replacements["%format%"] == "") {
                $templatePathPattern = str_replace("%format%.", "", $templatePathPattern);
            }

            if (is_file($file = strtr($templatePathPattern, $replacements)) && is_readable($file)) {
                if (null !== $this->debugger) {
                    $this->debugger->log(sprintf('Loaded template file "%s"', $file));
                }

                return new FileStorage($file);
            }

            if (null !== $this->debugger) {
                $logs[] = sprintf('Failed loading template file "%s"', $file);
            }
        }

        if (null !== $this->debugger) {
            foreach ($logs as $log) {
                $this->debugger->log($log);
            }
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

    /**
     * unshifts path pattern
     *
     * @param $path_pattern
     */
    public function unshiftPathPattern($path_pattern)
    {
        array_unshift($this->templatePathPatterns, $path_pattern);
    }

    /**
     * pushes path pattern
     *
     * @param $path_pattern
     */
    public function pushPathPattern($path_pattern)
    {
        $this->templatePathPatterns[] = $path_pattern;
    }

    /**
     * pushes path patterns
     *
     * @param $path_patterns
     */
    public function pushPathPatterns($path_patterns)
    {
        $this->templatePathPatterns = array_merge($this->templatePathPatterns, $path_patterns);
    }

    /**
     * sets path patterns
     *
     * @param $path_patterns
     */
    public function setPathPatterns($path_patterns)
    {
        $this->templatePathPatterns = $path_patterns;
    }
}