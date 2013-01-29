<?php
/**
 * Created by RubikIntegration Team.
 * Date: 1/29/13
 * Time: 2:41 PM
 * Question? Come to our website at http://rubikintegration.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Templating\Loader;

use Twig_LoaderInterface;
use Twig_ExistsLoaderInterface;

class TwigBaseLoader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{
    protected $cache;

    protected $parser;

    public function __construct($parser)
    {
        $this->parser = $parser;
    }

    public function getSource($name)
    {
        die("here");
    }

    public function getCacheKey($name)
    {
        die("here2");
    }

    public function isFresh($name, $time)
    {
        die("here3");
    }

    public function exists($name)
    {       return false;//               var_dump($name);die();
        $template = $this->parser->parse($name);

        var_dump($template);die();
        $name = (string) $name;
        if (isset($this->cache[$name])) {
            return true;
        }

        try {
            $this->findTemplate($name);

            return true;
        } catch (Twig_Error_Loader $exception) {
            return false;
        }
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
