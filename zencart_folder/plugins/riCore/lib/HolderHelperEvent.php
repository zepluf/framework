<?php 

namespace plugins\riCore;

use Symfony\Component\EventDispatcher\Event;

class HolderHelperEvent extends Event
{ 
    private $slot, $helper, $container;
    
    public function setSlot($slot){
        $this->slot = $slot;
        return $this;
    }
    
    public function getSlot(){
        return $this->slot;
    }
    
    public function setHelper($helper){
        $this->helper = $helper;
        return $this;
    }
    
    public function getHelper(){
        return $this->helper;
    }
    
    public function setContainer($container){
        $this->container = $container;
        return $this;
    }
    
    public function getContainer(){
        return $this->container;
    }
}