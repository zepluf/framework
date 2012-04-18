<?php

namespace plugins\riCore;

use plugins\riPlugin\Plugin;

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
			$engines,
			$patterns = array();
	
	public function __construct($dispatcher, $container){	   

	    $this->loader = $container->get('riCore.TemplateLoader');
	    
	    $this->patterns['default'] =  array(__DIR__.'/../../riSimplex/content/views/%name%');

        $this->engines = array(
            'php' => 
                new \Symfony\Component\Templating\PhpEngine(new TemplateNameParser(), $this->loader, array(new SlotsHelper(), $container->get('riCore.HolderHelper')))
        );
            
        // set the available template engines
        $container->setParameter('template.engines', array_values($this->engines));
        
        // init the engine
        $this->engine = $container->get('riCore.TemplateEngine');
        
        // always set router and reference to this
	    $this->set(array(
	    	'router' => new Routing\Generator\UrlGenerator($container->getParameter('routes'), $container->get('context')),
	        'riview' => $this,
	        'container' => $container	        
	    ));
	    
	    parent::__construct($dispatcher);
	}
	
	public function render($view, $parameters = null){
		$this->set($parameters);
		
		$view = explode('::', $view);
		
		// we will have to set path patterns to make sure we dont look for template files at extra places
		if(!empty($view[1])){		    		       
            $this->setPathPatterns($view[0]);		    
		}
		else {
		    $view[1] = $view[0];
		    $this->setPathPatterns();
		}
        		    
		// default to php		
		if(strpos($view[1], '.') === false) $view[1] .= '.php';		 		
        
		return $this->engine->render($view[1], $this->vars);		
	}
	
	public function setPathPatterns($scope = 'default'){
	    if(!isset($this->patterns[$scope]))
	        $this->patterns[$scope] = array(__DIR__.'/../../'.$scope.'/content/views/%name%');
	        
	    $patterns = $scope != 'default' ? array_merge($this->patterns[$scope], $this->patterns['default']) : $this->patterns['default'];
	    
	    $this->loader->setPathPatterns($patterns);
	}
	
	public function getHelper($name){
	    $name = explode('::', $name);
	    return $this->engine->getEngine('name.'.$name[0])->get($name[1]);
	}
		
	public function renderResponse($view, $parameters = null, Response $response = null){
		$content = $this->render($view, $parameters); 
		$response->setContent($this->render($view, $parameters));
		return $response;
	}
	
	public function set($vars){
		if(!is_array($vars)) $vars = array($vars);
		$this->vars = array_merge($this->vars, $vars);
	}	

	public function get($name){
	    return $this->vars[$name];
	}
}