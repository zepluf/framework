<?php

namespace plugins\riCore;

use Symfony\Component\Templating\Helper\Helper;

class HolderHelper extends Helper{
    
    protected $slots = array(), $dispatcher, $container;
    
    public function __construct($dispatcher, $container){
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }
    
    public function getName(){
        return 'holder';
    }
    
    public function add($slot, $content, $order = 0){
        $this->slots[$slot][] = array('order' => $order, 'content' => $content);
    }
    
    public function get($slot){
        $event = $this->container->get('riCore.HolderHelperEvent')->setContainer($this->container)->setSlot($slot)->setHelper($this);
        $this->dispatcher->dispatch('view.helper.holder.get.start', $event);
        $this->dispatcher->dispatch('view.helper.holder.get.start.'.$slot, $event);
        
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
		
		$this->dispatcher->dispatch('view.helper.holder.get.end', $event);
        $this->dispatcher->dispatch('view.helper.holder.get.end.'.$slot, $event);
		return $content;
         
    }
}