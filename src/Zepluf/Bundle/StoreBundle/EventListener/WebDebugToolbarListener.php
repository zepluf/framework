<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\EventListener;

use Symfony\Bundle\WebProfilerBundle\EventListener\WebDebugToolbarListener as BaseWebDebugToolbarListener;
use Symfony\Component\HttpKernel\KernelEvents;
use Zepluf\Bundle\StoreBundle\Event\CoreEvent;
use Zepluf\Bundle\StoreBundle\Events;

/**
 * WebDebugToolbarListener injects the Web Debug Toolbar.
 *
 * The onKernelResponse method must be connected to the kernel.response event.
 *
 * The WDT is only injected on well-formed HTML (with a proper </body> tag).
 * This means that the WDT is never included in sub-requests or ESI requests.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class WebDebugToolbarListener extends BaseWebDebugToolbarListener
{

    public function onPageEnd(CoreEvent $event)
    {
//        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
//            return;
//        }

        $response = $event->getResponse();
        $request = $event->getRequest();

        // do not capture redirects or modify XML HTTP Requests
        if ($request->isXmlHttpRequest()) {
            return;
        }

        if ($response->headers->has('X-Debug-Token') && $response->isRedirect() && $this->interceptRedirects) {
            $session = $request->getSession();
            if ($session && $session->getFlashBag() instanceof AutoExpireFlashBag) {
                // keep current flashes for one more request if using AutoExpireFlashBag
                $session->getFlashBag()->setAll($session->getFlashBag()->peekAll());
            }

            $response->setContent($this->twig->render('@WebProfiler/Profiler/toolbar_redirect.html.twig', array('location' => $response->headers->get('Location'))));
            $response->setStatusCode(200);
            $response->headers->remove('Location');
        }

        if (self::DISABLED === $this->mode
            || !$response->headers->has('X-Debug-Token')
            || $response->isRedirection()
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $request->getRequestFormat()
        ) {
            return;
        }

        $this->injectToolbar($response);
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::onPageEnd => array('onPageEnd', -128),
        );
    }
}
