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
use Zepluf\Bundle\StoreBundle\HoldersHelperEvents;
use Zepluf\Bundle\StoreBundle\Event\CoreEvent;
use Zepluf\Bundle\StoreBundle\Event\HoldersHelperEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CoreListener implements EventSubscriberInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * injects content into holders at pageEnd
     *
     * @param Event $event
     */
    public function onPageEnd(CoreEvent $event)
    {
        $holders = $this->container->get('settings')->get('theme.holders', array());

        foreach ($holders as $holder => $content) {
            $this->container->get('event_dispatcher')->addListener(HoldersHelperEvents::onHolderStart . '.' . $holder, array($this, 'onHolderStart'));
        }

        $event->setContent($this->container->get('templating.helper.holders')->injectHolders($event->getContent()));
    }

    /**
     * injects content into holder
     *
     * @param Event $event
     */
    public function onHolderStart(HoldersHelperEvent $event)
    {
        $holder_content = $this->container->get('settings')->get('theme.holders.' . $event->getHolder());
        foreach ($holder_content as $content) {
            $load = true;
            // we will check to see if this is a plugin's template, and if so we need to check if it is activated
            if (strpos($content["template"]["name"], ':') !== false) {
                $plugin = current(explode(':', $content["template"]["name"]));
                if (!$this->container->get("plugin")->isActivated($plugin)) {
                    $load = false;
                }
            }
            if ($load) {
                // run calls
                $data = (array)$content["template"]["parameters"];

                foreach($content["calls"] as $call) {
                    // is this a public function or a class method
                    if(strpos($call[0], "::") !== false) {
                        list($class, $method) = explode("::", $call[0]);
                        // is this a service?
                        if(strpos($class, "@") !== false) {
                            $service = substr($class, 1);
                            $object = $this->container->get($service);
                        }
                        else {
                            $object = new $class;
                        }

                        $data = array_merge($data, call_user_func_array(array($object, $method), $call[1]));
                    }
                    else {
                        $data = array_merge($data, $call[0]($call[1]));
                    }
                }

                $this->container->get('templating.helper.holders')->add($event->getHolder(), $this->container->get('view')->render($content["template"]["name"], $data));
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