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

use Symfony\Component\Templating\TemplateReference as BaseTemplateReference;

/**
 * Internal representation of a template.
 *
 * @author Victor Berchet <victor@suumit.com>
 */
class BundleTemplateReference extends BaseTemplateReference
{
    public function __construct($bundle = null, $controller = null, $name = null, $format = null, $engine = null)
    {
        $this->parameters = array(
            'bundle' => $bundle,
            'controller' => $controller,
            'name' => $name,
            'format' => $format,
            'engine' => $engine,
        );
    }

    /**
     * Returns the path to the template
     *  - as a path when the template is not part of a bundle
     *  - as a resource when the template is part of a bundle
     *
     * @return string A path to the template or a resource
     */
    public function getPath()
    {
        $controller = str_replace('\\', '/', $this->get('controller'));
        $format = $this->get('format');

        $path = (empty($controller) ? '' : $controller . '/') . $this->get('name') . '.' . (empty($format) ? $this->get('engine') : ($format . '.' . $this->get('engine')));

        return empty($this->parameters['bundle']) ? 'views/' . $path : '@' . $this->get('bundle') . '/Resources/views/' . $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogicalName()
    {
        if (!empty($this->parameters['format'])) {
//            die("A");
            return sprintf('%s:%s:%s.%s.%s', $this->parameters['bundle'], $this->parameters['controller'], $this->parameters['name'], $this->parameters['format'], $this->parameters['engine']);
        } else {
//            die("B");
            return sprintf('%s:%s:%s.%s', $this->parameters['bundle'], $this->parameters['controller'], $this->parameters['name'], $this->parameters['engine']);
        }
    }
}
