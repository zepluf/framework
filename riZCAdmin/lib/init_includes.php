<?php
use plugins\riPlugin\Plugin;
if(IS_ADMIN_FLAG){
    // add menu for ZC 1.5.0 >
    if(function_exists('zen_register_admin_page')){
        // define constants for menu
        foreach(Plugin::get('settings')->get('global.backend.menu') as $menu_key => $sub_menus){
            foreach($sub_menus as $key => $menu){
                $id = md5($menu['link']);
                define('ZEPLUF_NAME_' . $id, ri($menu['text']));
                define('ZEPLUF_URL_' . $id, ri($menu['link']));
            }                        
        }
    }
}