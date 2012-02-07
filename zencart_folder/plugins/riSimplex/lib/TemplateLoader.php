<?php

namespace plugins\riSimplex;

use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\TemplateReferenceInterface;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Storage\StringStorage;


class TemplateLoader extends FilesystemLoader{
    public $templates = array();

    public function setTemplate($name, $content)
    {
        $template = new TemplateReference($name, 'php');
        $this->templates[$template->getLogicalName()] = $content;
    }
    
    public function addPathPatterns($path_patterns){
        $path_patterns = (array)$path_patterns;
        
        $this->templatePathPatterns = array_merge($this->templatePathPatterns, $path_patterns);
    }
}