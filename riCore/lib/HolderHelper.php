<?php

namespace plugins\riCore;

use plugins\riPlugin\Plugin;
use Symfony\Component\Templating\Helper\Helper;

class HolderHelper extends Helper{
    
    protected $slots = array(), $dispatcher, $container;    
    
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
    
    public function get($slot, $silent = false){
        $event = Plugin::get('templating.holder.event')->setSlot($slot);
        Plugin::get('dispatcher')->dispatch(HolderHelperEvents::onHolderStart, $event);
        Plugin::get('dispatcher')->dispatch(HolderHelperEvents::onHolderStart . '.' . $slot, $event);

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
		
		Plugin::get('dispatcher')->dispatch(HolderHelperEvents::onHolderEnd, $event);
        Plugin::get('dispatcher')->dispatch(HolderHelperEvents::onHolderEnd . '.' .$slot, $event);

        $this->slots[$slot] = array();
        $content .= "<!-- holder: " . $slot . " -->";

		return $content;
    }
    
    public function injectHolders(&$content){
        // we want to loop through all the registered holders
        // scan the content to find holders
		preg_match_all("/(<!-- holder:)(.*?)(-->)/", $content, $matches, PREG_SET_ORDER);
		foreach ($matches as $val) {
			$content = str_replace($val[0], $this->get(trim($val[2])), $content);
		}
    }

    /**
     *
     */
    public function processHolders(){
        foreach(Plugin::get('settings')->get('global.holders', array()) as $position => $holders) {
            foreach($holders as $holder){
                $this->add($position, Plugin::get('riCore.View')->render($holder['template']));
            }
        }
    }
}