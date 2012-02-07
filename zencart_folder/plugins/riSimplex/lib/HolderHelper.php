<?php

namespace plugins\riSimplex;

use Symfony\Component\Templating\Helper\Helper;

class HolderHelper extends Helper{
    
    protected $slots = array();
    
    public function getName(){
        return 'holder';
    }
    
    public function add($slot, $content, $order = 0){
        $this->slots[$slot][] = array('order' => $order, 'content' => $content);
    }
    
    public function get($slot){
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