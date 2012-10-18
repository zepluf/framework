<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */
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