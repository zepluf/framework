<?php
use plugins\riPlugin\Plugin;
if(IS_ADMIN_FLAG){
    // add menu for ZC 1.5.0 >
    if(function_exists('zen_register_admin_page')){
        // define constants for menu
        foreach(Plugin::get('settings')->get('global.backend.menu') as $menu_key => $sub_menus){
            foreach($sub_menus as $key => $menu){
                $id = preg_replace("/[^A-Za-z0-9\s\s+\-]/", "_", $menu['link']);                
                define('ZEPLUF_MENU_NAME_' . $id, ri($menu['text']));
                define('ZEPLUF_MENU_URL_' . $id, ri($menu['link']));
                
            }                        
        }
    }	
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