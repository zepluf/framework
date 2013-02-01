<?php

use Zepluf\Bundle\StoreBundle\ZencartResponse;

try {
    $response = $kernel->handle($request);

    if ($response instanceof ZencartResponse) {
        if ($response->getContent() == ZencartResponse::CONTENT_NOT_FOUND) {
            if (!is_dir(DIR_WS_MODULES . 'pages/' . $current_page)) {
                // page not found code should be here
            }
            else {
                $response->setStatusCode(200);
            }
        }
        else {

        }
    } else {
//        $response->send();
//        $kernel->terminate($request, $response);
//        exit();
    }

    $core_event->setResponse($response);
} catch (Exception $e) {
    die("Error!");
}
