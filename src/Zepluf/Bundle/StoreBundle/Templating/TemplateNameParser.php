<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Templating;

use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * TemplateNameParser converts template names from the short notation
 * "bundle:section:template.format.engine" to TemplateReferenceInterface
 * instances.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TemplateNameParser implements TemplateNameParserInterface
{
    protected $kernel;
    protected $cache;

    /**
     * Constructor.
     *
     * @param KernelInterface $kernel A KernelInterface instance
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->cache = array();
    }

    /**
     * {@inheritdoc}
     */
    public function parse($name)
    {
        if ($name instanceof TemplateReferenceInterface) {
            return $name;
        } elseif (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        // normalize name
        $name = str_replace(':/', ':', preg_replace('#/{2,}#', '/', strtr($name, '\\', '/')));

        if (false !== strpos($name, '..')) {
            throw new \RuntimeException(sprintf('Template name "%s" contains invalid characters.', $name));
        }

        // is this the symfony default style?
        if(strpos($name, "::") !== false) {

        }
        $parts = explode(':', $name);

        switch (count($parts)) {
            case 1:
                array_unshift($parts, "templates", "current");
                break;
            case 2:
                // assumes bundle
                if("Bundle" == substr($parts[0], -6)) {
                    array_unshift($parts, "bundles");
                }
                // assume plugin
                else {
                    array_unshift($parts, "plugins");
                }
                break;
            case 3:
                switch($parts[0]) {
                    case "templates":
                    case "bundles":
                    case "plugins":
                        break;
                    default:
                        // assumes bundle
                        if("Bundle" == substr($parts[0], -6)) {
                            // change from BundleName:Controller:Path to bundles:BundleName:Controller/Path
                            $parts[2] = (!empty($parts[1]) ? $parts[1] . '/' : '') . $parts[2];
                            $parts[1] = $parts[0];
                            $parts[0] = "bundles";
                        }
                        // assume plugin
                        else {
                            throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid, the first part of the name is not within the supported format', $name));
                        }
                        break;
                }
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid (format is "plugins:pluginName:path/template.format.engine" or
                                                                                                    "plugins:pluginName:path/template.engine" or
                                                                                                    "bundles:bundleName:path/template.format.engine" or
                                                                                                    "bundles:bundleName:path/template.engine" or
                                                                                                    "templates:templateName:path/template.format.engine" or
                                                                                                    "templates:templateName:path/template.engine".', $name));

                break;
        }

        $path = dirname($parts[2]);
        if ($path == '.') {
            $path = '';
        }

        $elements = explode('.', $parts[2]);
        $engine = array_pop($elements);
        switch (count($elements)) {
            case 1:
                $format = 'html';
                break;
            case 2:
                $format = array_pop($elements);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid (format is "plugin:path/template.format.engine" or "plugin:path/template.engine" or "path/template.format.engine" or "path/template.engine") or "template.format.engine" or "template.engine".', $name));
                break;
        }

        $template = new TemplateReference($parts[0], $parts[1], $path, str_replace($path . '/', "", current($elements)), $format, $engine);

        return $this->cache[$name] = $template;
    }
}