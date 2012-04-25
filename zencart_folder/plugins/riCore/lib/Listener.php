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
    	$content = &$event->getContent();
    	Plugin::get('riCjLoader.Loader')->injectAssets($content);
        // extend here the functionality of the core
        // ...
    }
}