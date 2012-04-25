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
    
    public function unshiftPathPattern($path_pattern){              
        array_unshift($this->templatePathPatterns, $path_patterns);
    }
    
    public function pushPathPattern($path_pattern){              
        $this->templatePathPatterns[] = $path_pattern;
    }
    
    public function pushPathPatterns($path_patterns){              
        $this->templatePathPatterns = array_merge($this->templatePathPatterns, $path_patterns);
    }
    
    public function setPathPatterns($path_patterns){
        $this->templatePathPatterns = $path_patterns;
    }
}