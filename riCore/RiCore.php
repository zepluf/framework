<?php
namespace plugins\riCore;

use plugins\riCore\Event;
use plugins\riCore\PluginCore;
use plugins\riPlugin\Plugin;


class RiCore extends PluginCore{
	public function init(){
	    if(Plugin::get('riPlugin.Settings')->get('riCore.parse_holders')){	    
		    $listener = Plugin::get('riCore.Listener');
		    Plugin::get('dispatcher')->addListener(\plugins\riCore\Events::onPageEnd, array($this, 'onPageEnd'));
	    }
	}	
    
	public function onPageEnd(Event $event)
    {        
    	$content = &$event->getContent();
    	Plugin::get('templating.holder')->injectHolders($content);
        // extend here the functionality of the core
        // ...
    }
}