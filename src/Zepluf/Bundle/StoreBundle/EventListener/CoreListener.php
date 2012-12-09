<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 11/8/12
 * Time: 11:42 AM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\EventListener;

use Zepluf\Bundle\StoreBundle\Events;
use Zepluf\Bundle\StoreBundle\Event\CoreEvent;

class CoreListener implements EventSubscriberInterface
{
    /**
     * injects content into holders at pageEnd
     *
     * @param Event $event
     */
    public function onPageEnd(CoreEvent $event)
    {
        $holders = Plugin::get('settings')->get('global.' . Plugin::getEnvironment() . '.holders', array());

        foreach($holders as $holder => $content) {
            $this->eventDispatcher->addListener(HoldersHelperEvents::onHolderStart . '.' . $holder, array($this, 'onHolderStart'));
        }

        $event->setContent(Plugin::get('templating.helper.holders')->injectHolders($event->getContent()));
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
                if(!Plugin::isActivated($plugin)) {
                    $load = false;
                }
            }
            if($load) {
                Plugin::get('templating.helper.holders')->add($event->getHolder(), Plugin::get('view')->render($content['template'], $content['parameters']));
            }
        }
    }

    /**
     * @static
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::onPageEnd => array('onPageEnd', 128),
        );
    }

}