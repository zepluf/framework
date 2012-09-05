<?php 

namespace plugins\riCore;

class Event extends \Symfony\Component\EventDispatcher\Event
{ 
    private $content;
    
    public function setContent($content){
        $this->content = $content;
    } 

	public function getContent(){
        return $this->content;        
    }
}