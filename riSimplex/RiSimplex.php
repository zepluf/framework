<?php
/**
 * Created by RubikIntegration Team.
 * Date: 8/13/12
 * Time: 8:24 PM
 * Question? Come to our website at http://rubikintegration.com
 */

namespace plugins\riSimplex;

use plugins\riPlugin\Plugin;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\KernelEvents;

class RiSimplex extends \plugins\riCore\PluginCore{
    public function init(){
        Plugin::get('dispatcher')->addListener(\Symfony\Component\HttpKernel\KernelEvents::CONTROLLER, array($this, 'onControllerStart'), -9999);
    }

    public function onControllerStart(Event $event){
        $controller = $event->getController();
        $controller[0]->beforeAction($event);
    }
}