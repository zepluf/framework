<?php 

namespace plugins\riCore;

class HolderHelperEvent extends \Symfony\Component\EventDispatcher\Event
{ 
    private $slot;
    
    public function setSlot($slot){
        $this->slot = $slot;
        return $this;
    }
    
    public function getSlot(){
        return $this->slot;
    }
    /*
    public function setHelper($helper){
        $this->helper = $helper;
        return $this;
    }
    
    public function getHelper(){
        return $this->helper;
    }
    
    */
}