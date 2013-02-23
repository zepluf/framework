<?php

use Zepluf\Bundle\StoreBundle\ZencartResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Zepluf\Bundle\StoreBundle\Events;

try {
    $response = $kernel->handle($request);

    if ($response instanceof ZencartResponse) {
        if ($response->getContent() == ZencartResponse::CONTENT_NOT_FOUND) {
            $page = $container->get('utility.file')->sanitizeFilename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '');
            if (!empty($page) && !is_dir(DIR_WS_MODULES . 'pages/' . $page)) {
                // page not found code should be here
                $response =  new RedirectResponse($view['router']->generate('storebundle.page_not_found'));
                $response->send();
                exit();
            }
            else {
                $response->setStatusCode(200);
            }
        }
        else {

        }
    } else {
        $core_event->setResponse($response);
        $container->get('event_dispatcher')->dispatch(Events::onPageEnd, $core_event);
        $response->send();
        $kernel->terminate($request, $response);
        exit();
    }

    $core_event->setResponse($response);
} catch (Exception $e) {
    die("Error!");
}
