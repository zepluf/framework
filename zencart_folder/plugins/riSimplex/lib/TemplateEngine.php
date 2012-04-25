<?php

namespace plugins\riSimplex;

use Symfony\Component\Templating\DelegatingEngine;

class TemplateEngine extends DelegatingEngine
{
    public function getEngine($name){
        return parent::getEngine($name);
    }
}