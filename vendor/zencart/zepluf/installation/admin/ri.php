<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: zones.php 1969 2005-09-13 06:57:21Z drbyte $
//
require('includes/application_top.php');

// added to allow setting up core plugins AFTER all zencart variables have been setup
if($_GET['setup'] == 1){
    $container->get("plugin")->setup($container, (bool)$_GET['force']);
    die(sprintf("Setup has been done! You can <a href='%s'>click here</a> to visit the ZePLUF Manager", 'ri.php/ricore/manager/'));
}

try{
    $response = $kernel->handle($request, Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST, false);
}catch (Exception $e){
    // do something?
    echo $e->getMessage();
    exit('something went wrong with the routing');
}

//some hacks for zencart
ob_start();
require(DIR_WS_INCLUDES . 'header.php');
$header = ob_get_clean();

ob_start();
require(DIR_WS_INCLUDES . 'footer.php');
$footer = ob_get_clean();

$content = $response->getContent();
$content = str_replace(array("</head>", "</body>"), array('</head>' . $header, $footer . '</body>'), $content);

echo $content;

$print_content = false;
require('includes/application_bottom.php');

$response->setContent($content);
$response->send();

