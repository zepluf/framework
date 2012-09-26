<?php
use plugins\riPlugin\Plugin;

// we need to add some default paths into our view so that it knows where to look for template files
if(IS_ADMIN_FLAG){
    $riview->addDefaultPathPattern('template', DIR_FS_ADMIN . 'includes/templates/template_default/');
}
else{
	$riview->addDefaultPathPattern('template', DIR_FS_CATALOG . DIR_WS_TEMPLATE);
}

// set locale
Plugin::get('translator')->setLocale($_SESSION['languages_code']);

// bof ri: ZePLUF
$core_event = plugins\riPlugin\Plugin::get('riCore.Event');
Plugin::get('dispatcher')->dispatch(plugins\riCore\Events::onPageStart, $core_event);
ob_start();
// eof ri: ZePLUF