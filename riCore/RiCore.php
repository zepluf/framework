<?php
namespace plugins\riCore;

use plugins\riCore\Event;
use plugins\riCore\PluginCore;
use plugins\riPlugin\Plugin;
use plugins\riCore\Events;
use plugins\riCore\HolderHelperEvents;

class RiCore extends PluginCore{
	public function init(){
        Plugin::get('dispatcher')->addListener(Events::onPageEnd, array($this, 'onPageEnd'));

        global $autoLoadConfig;
        // we want to include the loader into the view for easy access, we need to do it after the template is loaded
        $autoLoadConfig[200][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/lib/init_includes.php');

        if(!IS_ADMIN_FLAG){
            $autoLoadConfig[999][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/lib/frontend_routing.php');
        }

        // for the holders
        $holders = Plugin::get('settings')->get('global.holders', array());

        foreach($holders as $holder => $content){
            Plugin::get('dispatcher')->addListener(HolderHelperEvents::onHolderStart . '.' . $holder, array($this, 'onHolderStart'));
        }
	}	
	
	public function onPageEnd(Event $event)
    {
        Plugin::get('templating.holder')->processHolders();

        $event->setContent(Plugin::get('templating.holder')->injectHolders($event->getContent()));
        // extend here the functionality of the core
        // ...
    }

    public function onHolderStart(Event $event){
        $holder_content = Plugin::get('settings')->get('global.holders.'.$event->getSlot());
        foreach($holder_content as $content){
            $load = true;

            // we will check to see if this is a plugin's template, and if so we need to check if it is activated
            if(strpos($content['template'], '::') !== false){
                $plugin = current(explode('::', $content['template']));
                if(!Plugin::isActivated($plugin))
                    $load = false;
            }
            if($load)
            Plugin::get('templating.holder')->add($event->getSlot(), Plugin::get('view')->render($content['template'], $content['parameters']));
        }
    }
}