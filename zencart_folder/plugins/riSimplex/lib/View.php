<?php

namespace plugins\riSimplex;

use plugins\riPlugin\Object;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

class View extends Object{
	private $vars = array(),
			$slots = array();
	
	public function render($view, $parameters = null){
		
		// a hack to put router in view
		if(!isset($this->vars['router']))
			$this->vars['router'] = new Routing\Generator\UrlGenerator($this->container->getParameter('routes'), $this->container->get('context'));
			
		$view = explode('::', $view);
		
		ob_start();
		$this->setVars($parameters);
		if(!empty($this->vars)) extract($this->vars, EXTR_OVERWRITE);
		
		$view_path = __DIR__.'/../../'.$view[0].'/content/views/'.$view[1].'.php';
		
		if(file_exists($view_path))	
			require(__DIR__.'/../../'.$view[0].'/content/views/'.$view[1].'.php');
		else{
			echo "missing:" . __DIR__.'/../../'.$view[0].'/content/views/'.$view[1].'.php';
		}
		
		$content = ob_get_clean();
		
		return $content;		
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