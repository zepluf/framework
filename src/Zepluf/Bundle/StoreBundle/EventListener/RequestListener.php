<?php
/**
 * Created by Rubikin Team.
 * Date: 3/27/13
 * Time: 9:54 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
//        $request = $event->getRequest();
//
//        // force ssl based on authentication
//        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
//            if (!$request->isSecure()) {
//                $request->server->set('HTTPS', true);
//                $request->server->set('SERVER_PORT', 443);
//                $event->setResponse(new RedirectResponse($request->getUri()));
//            }
//        } else {
//            if ($request->isSecure()) {
//                $request->server->set('HTTPS', false);
//                $request->server->set('SERVER_PORT', 80);
//                $event->setResponse(new RedirectResponse($request->getUri()));
//            }
//        }
    }
}