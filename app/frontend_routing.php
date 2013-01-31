<?php
try {
    $response = $kernel->handle($request);

    if ($response instanceof Zepluf\Bundle\StoreBundle\ZencartResponse) {
        if ($response->getContent() == \Zepluf\Bundle\StoreBundle\ZencartResponse::CONTENT_NOT_FOUND) {
            if (!is_dir(DIR_WS_MODULES . 'pages/' . $current_page)) {

            }
        }
        else {

        }
    } else {
        $response->send();
        $kernel->terminate($request, $response);
        exit();
    }
} catch (Exception $e) {
    die("Error!");
}
