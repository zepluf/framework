<?php 

namespace plugins\riPlugin;

use Symfony\Component\EventDispatcher\Event;

class PluginEvent extends Event
{ 
    private $settings, $plugin;

    /**
     * sets the plugin
     *
     * @param $plugin
     * @return PluginEvent
     */
	public function setPlugin($plugin){
        $this->plugin = $plugin;
        return $this;
    }   

    /**
     * gets the plugin
     *
     * @return mixed
     */
    public function getPlugin(){
    	return $this->plugin;
    }

    /**
     * set settings
     *
     * @param $settings
     * @return PluginEvent
     */
    public function setSettings($settings){
        $this->settings = $settings;
        return $this;
    }   

    /**
     * gets settings
     *
     * @return mixed
     */
    public function getSettings(){
    	return $this->settings;
    }
}