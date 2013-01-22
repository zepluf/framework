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

        $parts = explode(':', $name);

        switch (count($parts)) {
            case 1:
                $plugin = '';
                $path = $parts[0];
                break;
            case 2:
                $plugin = $parts[0];
                $path = $parts[1];
                break;
            case 3: // bundle case
                $bundle = $parts[0];
                $controller = $parts[1];
                $isBundle = true;
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid (format is "plugin:path/template.format.engine" or "plugin:path/template.engine" or "path/template.format.engine" or "path/template.engine") or "template.format.engine" or "template.engine".', $name));
                break;
        }

        if (!$isBundle) {
            $elements = explode('.', basename($path));
            $path = dirname($path);
            if ($path == '.') {
                $path = '';
            }
            $engine = array_pop($elements);
            switch (count($elements)) {
                case 1:
                    $format = '';
                    break;
                case 2:
                    $format = array_pop($elements);
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid (format is "plugin:path/template.format.engine" or "plugin:path/template.engine" or "path/template.format.engine" or "path/template.engine") or "template.format.engine" or "template.engine".', $name));
                    break;
            }
            $template = new TemplateReference($plugin, $path, implode('.', $elements), $format, $engine);
        } else {
            $elements = explode('.', $parts[2]);
            $engine = array_pop($elements);
            switch (count($elements)) {
                case 1:
                    $format = '';
                    break;
                case 2:
                    $format = array_pop($elements);
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid (format is "plugin:path/template.format.engine" or "plugin:path/template.engine" or "path/template.format.engine" or "path/template.engine") or "template.format.engine" or "template.engine".', $name));
                    break;
            }
            $template = new BundleTemplateReference($bundle, $controller, implode('.', $elements), $format, $engine);

            if ($template->get('bundle')) {
                try {
                    $this->kernel->getBundle($template->get('bundle'));
                } catch (\Exception $e) {
                    throw new \InvalidArgumentException(sprintf('Template name "%s" is not valid.', $name), 0, $e);
                }
            }
        }

        return $this->cache[$name] = $template;
    }
}