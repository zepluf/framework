<?php
/**
 * @package admin
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: application_bottom.php 17049 2010-07-29 06:19:52Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
// close session (store variables)
session_write_close();

if (STORE_PAGE_PARSE_TIME == 'true') {
    if (!is_object($logger)) $logger = new logger;
    echo $logger->timer_stop(DISPLAY_PAGE_PARSE_TIME);
}


// bof ri: ZePLUF
$content = ob_get_clean();
if(is_object($core_event)){
    $core_event->setContent($content);
    $container->get('dispatcher')->dispatch(plugins\riCore\Events::onPageEnd, $core_event);
    $content = $core_event->getContent();
}
if(!isset($print_content) || $print_content) echo $content;
// eof ri: cjloader
