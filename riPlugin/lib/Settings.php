<?php
namespace plugins\riPlugin;

class Settings extends ParameterBag{

    private $is_initiated = false;

    public function init($settings){
        $this->_parameters = $settings;
        $this->is_initiated = true; 
    }
    
    public function isInitiated(){
        return $this->is_initiated;
    }
}