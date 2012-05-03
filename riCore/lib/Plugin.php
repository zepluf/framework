<?php

namespace plugins\riCore;

class Plugin{
    
    protected $dispatcher, $container;
    
    public function __construct($dispatcher, $container){
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }
    
    public function init(){
        
    }
}