<?php

namespace plugins\riCore;

abstract class PluginCore{

    /**
     * This method will be called when the plugin is loaded
     */
    public function init(){
        
    }

    /**
     * This method will be called when the plugin is installed
     *
     * @return bool
     */
    public function install(){          
        return true;
    }

    /**
     * This method will be called when the plugin is uninstalled
     *
     * @return bool
     */
    public function uninstall(){
        return true;
    }

    /**
     * This method will be called when the plugin is activated
     *
     * @return bool
     */
    public function activate(){          
        return true;
    }

    /**
     * This method will be called when the plugin is deactivated
     *
     * @return bool
     */
    public function deactivate(){
        return true;
    }
}