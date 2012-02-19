<?php

namespace plugins\riCard;

use plugins\riCore\PluginCore;

class RiCard extends PluginCore{
    
    public function init(){
        /*$this->dispatcher->addListener('view.helper.holder.get.start', function ($event) {
            if($event->getSlot() == 'main')
            $event->getHelper()->add($event->getSlot(), $event->getContainer()->get('riCore.View')->render('riCard::test.php'));
            // will be executed when the foo.action event is dispatched
        });*/
    }
}