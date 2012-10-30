<?php
/**
 * the abstract class for any plugin's core class
 */

namespace plugins\riCore;

/**
 * plugin core class
 */
abstract class PluginCore{

    /**
     * This method will be called when the plugin is loaded
     *
     * optional
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