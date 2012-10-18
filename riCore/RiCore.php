<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace plugins\riCore;

use plugins\riCore\Event;
use plugins\riCore\PluginCore;
use plugins\riPlugin\Plugin;
use plugins\riCore\Events;
use plugins\riCore\HolderHelperEvents;

/**
 * plugin core class
 */
class RiCore extends PluginCore{

    /**
     * inits
     */
	public function init(){
        Plugin::get('dispatcher')->addListener(Events::onPageEnd, array($this, 'onPageEnd'));

        global $autoLoadConfig;

        // we want to include the loader into the view for easy access, we need to do it after the template is loaded
        $autoLoadConfig[200][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/lib/init_includes.php');

        if(!IS_ADMIN_FLAG){
            $autoLoadConfig[999][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/lib/frontend_routing.php');
        }
	}

    /**
     * injects content into holders at pageEnd
     *
     * @param Event $event
     */
	public function onPageEnd(Event $event)
    {
        $holders = Plugin::get('settings')->get('global.' . Plugin::getEnvironment() . '.holders', array());

        foreach($holders as $holder => $content){
            Plugin::get('dispatcher')->addListener(HolderHelperEvents::onHolderStart . '.' . $holder, array($this, 'onHolderStart'));
        }

        $event->setContent(Plugin::get('templating.holder')->injectHolders($event->getContent()));
        // extend here the functionality of the core
        // ...
    }

    /**
     * injects content into holder
     *
     * @param Event $event
     */
    public function onHolderStart(Event $event){
        $holder_content = Plugin::get('settings')->get('global.' . Plugin::getEnvironment() . '.holders.' . $event->getHolder());
        foreach($holder_content as $content){
            $load = true;

            // we will check to see if this is a plugin's template, and if so we need to check if it is activated
            if(strpos($content['template'], '::') !== false){
                $plugin = current(explode('::', $content['template']));
                if(!Plugin::isActivated($plugin))
                    $load = false;
            }
            if($load)
            Plugin::get('templating.holder')->add($event->getHolder(), Plugin::get('view')->render($content['template'], $content['parameters']));
        }
    }
}