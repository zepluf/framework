<?php
/**
 * Created by RubikIntegration Team.
 * User: vunguyen
 * Date: 6/25/12
 * Time: 3:53 PM
 * Question? Come to our website at http://rubikin.com
 */
use plugins\riPlugin\Plugin;

// if this is not a real page, then we will attempt to use or ZePLUF MVC and sees if any controller is being mapped to it
if (!is_dir(DIR_WS_MODULES .  'pages/' . $current_page)){

    // first we need to load our framework
    Plugin::load(array('riSimplex'));

    $container->setParameter('request', $request);

    // try to see if any controller is mapped and work okie
    // TODO: will need print out error messages
    try{
        global $response, $current_page, $current_page_base;
        $response = Plugin::get('riSimplex.Framework')->customHandle($current_page, $request);
        if($response instanceof \Symfony\Component\HttpFoundation\RedirectResponse)
            $response->send();
        $_GET['main_page'] = $current_page = $current_page_base = 'ri';
    }catch (\Exception $e){
        zen_redirect(zen_href_link('page_not_found'));
    }
}