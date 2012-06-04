<?php

namespace plugins\riCore;

abstract class PluginCore{
       
    public function init(){
        
    }
    
    public function install(){          
        return true;
    }
    
    public function uninstall(){
        return true;
    }
    
    public function activate(){          
        return true;
    }
    
    public function deactivate(){
        return true;
    }
}