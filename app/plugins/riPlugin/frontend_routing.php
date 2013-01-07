<?php
/**
 * Created by RubikIntegration Team.
 * User: vunguyen
 * Date: 6/25/12
 * Time: 3:53 PM
 * Question? Come to our website at http://rubikin.com
 */

if (strpos($request->getUri(), "index.php") === false) {
    // if this is not a real page, then we will attempt to use or ZePLUF MVC and sees if any controller is being mapped to it
    $path_info = $request->getPathInfo();
    if (!empty($path_info)) {
        try {
            $match = $container->get("router")->getMatcher()->match($path_info);
            foreach ($match as $key => $value) {
                if (strpos($key, "parameter_") !== false) {
                    $_key = substr($key, 10);
                    $_GET[$_key] = $_REQUEST[$_key] = $value;
                }
            }
        } catch (Exception $e) {

        }
    }
} else {
    if (!is_dir(DIR_WS_MODULES . 'pages/' . $current_page)) {

        // first we need to load our framework
        // try to see if any controller is mapped and work okie
        // TODO: will need print out error messages
        try {
            global $response, $current_page, $current_page_base;
            $response = $container->get("http_kernel")->customHandle($current_page, $request);

            if ($response instanceof \Symfony\Component\HttpFoundation\RedirectResponse) {
                $response->send();
                $container->get("http_kernel")->terminate($request, $response);
            }

            $_GET['main_page'] = $current_page = $current_page_base = 'ri';
        } catch (\Exception $e) {
            zen_redirect(zen_href_link('page_not_found'));
        }
    }
}