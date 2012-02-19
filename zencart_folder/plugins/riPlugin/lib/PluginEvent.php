<?php 

namespace plugins\riPlugin;

use Symfony\Component\EventDispatcher\Event;

class PluginEvent extends Event
{ 
    private $settings, $plugin;
    
	public function setPlugin($plugin){
        $this->plugin = $plugin;
        return $this;
    }   
    
    public function getPlugin(){
    	return $this->plugin;
    }
    
    public function setSettings($settings){
        $this->settings = $settings;
        return $this;
    }   
    
    public function getSettings(){
    	return $this->settings;
    }
}