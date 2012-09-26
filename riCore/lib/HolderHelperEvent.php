<?php 

namespace plugins\riCore;

class HolderHelperEvent extends Event
{ 
    private $holder;

    /**
     * sets holder name
     *
     * @param $slot
     * @return HolderHelperEvent
     */
    public function setHolder($holder){
        $this->holder = $holder;
        return $this;
    }

    /**
     * gets holder name
     *
     * @return mixed
     */
    public function getHolder(){
        return $this->holder;
    }
}