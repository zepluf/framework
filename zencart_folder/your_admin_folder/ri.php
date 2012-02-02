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
require('../plugins/riSimplex/init.php');

//some hacks for zencart
ob_start();
require(DIR_WS_INCLUDES . 'header.php');
$header = ob_get_clean();

ob_start();	
require(DIR_WS_INCLUDES . 'footer.php');
$footer = ob_get_clean();

ob_start();	
require(DIR_WS_INCLUDES . 'application_bottom.php');
$application_bottom = ob_get_clean();

$content = $response->getContent();

$content = str_replace(array("{header}", "{footer}", "{application_bottom}"), array($header, $footer, $application_bottom), $content);

$response->setContent($content);
$response->send();
