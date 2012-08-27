<?php
namespace plugins\riCore;

use plugins\riCore\Event;
use plugins\riCore\PluginCore;
use plugins\riPlugin\Plugin;


class RiCore extends PluginCore{
	public function init(){
        Plugin::get('dispatcher')->addListener(\plugins\riCore\Events::onPageEnd, array($this, 'onPageEnd'));

        global $autoLoadConfig;
        // we want to include the loader into the view for easy access, we need to do it after the template is loaded
        $autoLoadConfig[200][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/lib/init_includes.php');

        if(!IS_ADMIN_FLAG){
            $autoLoadConfig[999][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/lib/frontend_routing.php');
        }

        // for the holders
        $holders = Plugin::get('settings')->get('global.holders', array());

        foreach($holders as $holder => $holder_parameters){
            Plugin::get('dispatcher')->addListener(\plugins\riCore\HolderHelperEvents::onHolderStart . '.' . $holder, array($this, 'onHolderStart'));
        }
	}	
	
	public function onPageEnd(Event $event)
    {
        Plugin::get('templating.holder')->processHolders();

        $content = &$event->getContent();
        Plugin::get('templating.holder')->injectHolders($content);
        // extend here the functionality of the core
        // ...
    }

    public function onHolderStart(Event $event){
        $holder_settings = Plugin::get('settings')->get('global.holders.'.$event->getSlot());
        Plugin::get('templating.holder')->add($event->getSlot(), Plugin::get('view')->render($holder_settings['template'], $holder_settings['parameters']));
    }
}