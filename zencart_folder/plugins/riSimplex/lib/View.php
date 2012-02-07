<?php

namespace plugins\riSimplex;

use Symfony\Component\Templating\PhpEngine;

use plugins\riPlugin\Object;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Helper\SlotsHelper;


class View extends Object{
	private $vars = array(),			
			$loader,
			$engine,
			$engines;
	
	public function __construct($dispatcher, $container){	   

	    $this->loader = $container->get('riSimplex.TemplateLoader');
	    $this->loader->addPathPatterns(array(
            __DIR__.'/../../riSimplex/content/views/%name%'
        ));

        $this->engines = array(
            'php' => 
                new \Symfony\Component\Templating\PhpEngine(new TemplateNameParser(), $this->loader, array(new SlotsHelper(), $container->get('riSimplex.HolderHelper')))
        );
            
        // set the available template engines
        $container->setParameter('template.engines', array_values($this->engines));
        
        // init the engine
        $this->engine = $container->get('riSimplex.TemplateEngine');
        
        // always set router and reference to this
	    $this->setVars(array(
	    	'router' => new Routing\Generator\UrlGenerator($container->getParameter('routes'), $container->get('context')),
	        'riview' => $this
	    ));
	    
	    parent::__construct($dispatcher);
	}
	
	public function render($view, $parameters = null){
		$this->setVars($parameters);
		
		$view = explode('::', $view);
		
		// default to php
		if(strpos($view[1], '.') === false) $view[1] .= '.php';
		 
		$this->loader->addPathPatterns(array(
            __DIR__.'/../../'.$view[0].'/content/views/%name%'
        ));
        
		return $this->engine->render($view[1], $this->vars);		
	}
	
	public function get($name){
	    $name = explode('::', $name);
	    return $this->engine->getEngine('name.'.$name[0])->get($name[1]);
	}
	
	private function getPath($plugin, $view){
	    $path = __DIR__.'/../../'.$plugin.'/content/views/'.$view.'.php';
	    if(file_exists($path))
	        return $path;
	        
	    // fall back to default view    
	    $path = __DIR__.'/../../riSimplex/content/views/'.$view.'.php';
	    if(file_exists($path))
	        return $path;  

	    return false;
	}
	
	public function renderResponse($view, $parameters = null, Response $response = null){
		$content = $this->render($view, $parameters); 
		$response->setContent($this->render($view, $parameters));
		return $response;
	}
	
	public function setVars($vars){
		if(!is_array($vars)) $vars = array($vars);
		$this->vars = array_merge($this->vars, $vars);
	}
	
	public function appendSlot($slot, $content, $order = 0){
		$this->slots[$slot][] = array('order' => $order, 'content' => $content); 
	}
	
	public function renderSlot($slot){
		$content = '';
		if(isset($this->slots[$slot]) && count($this->slots[$slot])> 0){
			usort($this->slots[$slot], function($a, $b) {
				if ($a['order'] == $b['order']) {
	        		return 0;
				}
	    		return ($a['order'] < $b['order']) ? -1 : 1;
			});
			
			
			foreach ($this->slots[$slot] as $c)
				$content .= $c['content'];
		}
		
		return $content;	 
	}
}