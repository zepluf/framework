<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 11/5/12
 * Time: 3:55 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zepluf\Bundle\StoreBundle\ZencartResponse;

/**
 * Attach the beforeAction method to all controller action call
 */
class ControllerListener implements EventSubscriberInterface
{
    /**
     * We use this to make sure the beforeAction method is always called before any controller action
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if(method_exists($controller[0], "beforeAction")) {
            $controller[0]->beforeAction($event);
        }
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof NotFoundHttpException) {
            // we need to check if the page does exist on Zencart
            $response = new ZencartResponse(ZencartResponse::CONTENT_NOT_FOUND);
            $event->setResponse($response);
            return;
        }
    }


    /**
     * @static
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array('onKernelController', 128),
            KernelEvents::EXCEPTION => array('onKernelException', 1)
        );
    }
}