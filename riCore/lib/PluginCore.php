<?php

namespace plugins\riCore;

use plugins\riPlugin\Plugin;

abstract class PluginCore{
    
    protected $dispatcher, $container;
    
    public function __construct($dispatcher, $container){
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }
    
    public function init(){
        
    }
    
    public function install(){          
        return true;
    }
    
    public function uninstall(){
        return true;
    }
}