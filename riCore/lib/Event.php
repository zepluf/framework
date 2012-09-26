<?php 

namespace plugins\riCore;

class Event extends \Symfony\Component\EventDispatcher\Event
{ 
    private $content;

    /**
     * sets content
     *
     * @param $content
     */
    public function setContent($content){
        $this->content = $content;
    } 

    /**
     * gets content
     *
     * @return mixed
     */
	public function getContent(){
        return $this->content;        
    }
}