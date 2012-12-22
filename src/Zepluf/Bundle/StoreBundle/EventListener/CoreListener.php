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
        $holders = $event->getContainer->get('settings')->get('theme.holders', array());

        foreach ($holders as $holder => $content) {
            $this->eventDispatcher->addListener(HoldersHelperEvents::onHolderStart . '.' . $holder, array($this, 'onHolderStart'));
        }

        $event->setContent($event->getContainer->get('templating.helper.holders')->injectHolders($event->getContent()));
    }

    /**
     * injects content into holder
     *
     * @param Event $event
     */
    public function onHolderStart(Event $event)
    {
        $holder_content = $event->getContainer->get('settings')->get('theme.holders.' . $event->getHolder());
        foreach ($holder_content as $content) {
            $load = true;
            // we will check to see if this is a plugin's template, and if so we need to check if it is activated
            if (strpos($content['template'], ':') !== false) {
                $plugin = current(explode(':', $content['template']));
                if (!$event->getContainer->get("plugin")->isActivated($plugin)) {
                    $load = false;
                }
            }
            if ($load) {
                // run calls
                $data = (array)$content['parameters'];
                $data = array_merge($data, calls());


                $event->getContainer->get('templating.helper.holders')->add($event->getHolder(), $event->getContainer->get('view')->render($content['template'], $data));
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
            Events::onPageEnd => array('onPageEnd', 128)
        );
    }

}