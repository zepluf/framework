<?php
/**
 * Core Listener 
 */
namespace plugins\riCore;
  
use plugins\riPlugin\Plugin;

class Listener
{
    // ...
    public function onPageEnd(Event $event)
    {
    	
    	Plugin::get('riCjLoader.Loader')->injectAssets($event->getContent());
        // extend here the functionality of the core
        // ...
    }
}