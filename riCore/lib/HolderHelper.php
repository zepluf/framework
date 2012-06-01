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
    
    /**
     * 
     */
    public function add($slot, $content, $order = 0){
        $this->slots[$slot][] = array('order' => $order, 'content' => $content);
        return $this;
    }
    
    public function get($slot){
        $event = $this->container->get('templating.holder.event')->setSlot($slot);
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
    
    public function injectHolders(&$content){                
        // scan the content to find holders
		preg_match_all("/(<!-- holder:)(.*?)(-->)/", $content, $matches, PREG_SET_ORDER);		
		foreach ($matches as $val) {
			$content = str_replace($val[0], $this->get(trim($val[2])), $content);
		}
    }
}