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
class TemplateReference extends BaseTemplateReference
{
    public function __construct($template = null, $plugin = null, $path = null, $name = null, $format = null, $engine = null)
    {
        $this->parameters = array(
            'plugin' => $plugin,
            'path' => $path,
            'name' => $name,
            'format' => $format,
            'engine' => $engine,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getLogicalName()
    {
        return sprintf('%s:%s:%s.%s.%s', $this->parameters['plugin'], $this->parameters['path'], $this->parameters['name'], $this->parameters['format'], $this->parameters['engine']);
    }
}
