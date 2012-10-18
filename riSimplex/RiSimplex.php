<?php
/**
 * Created by RubikIntegration Team.
 * Date: 8/13/12
 * Time: 8:24 PM
 * Question? Come to our website at http://rubikin.com
 */

namespace plugins\riSimplex;

use plugins\riPlugin\Plugin;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * plugin framework main class
 */
class RiSimplex extends \plugins\riCore\PluginCore{

    /**
     * listens to controller start
     */
    public function init(){
        Plugin::get('dispatcher')->addListener(\Symfony\Component\HttpKernel\KernelEvents::CONTROLLER, array($this, 'onControllerStart'), -9999);
    }

    /**
     * for ZePLUF to run smoothly we will need to turn of the MISSING_PAGE_CHECK
     *
     * @return bool
     */
    public function install(){
        global $db;
        $db->Execute('UPDATE TABLE ' . TABLE_CONFIGURATION . " SET configuration_value = 'Off' WHERE configuration_value = 'MISSING_PAGE_CHECK'");
        return true;
    }

    /**
     * triggers the beforeAction
     *
     * @param \Symfony\Component\EventDispatcher\Event $event
     */
    public function onControllerStart(Event $event){
        $controller = $event->getController();
        $controller[0]->beforeAction($event);
    }
}