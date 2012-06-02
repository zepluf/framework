<?php
namespace plugins\riZCAdmin;

use plugins\riPlugin\Plugin;

class ZCAdmin{
    public function injectAutoLoads($auto_loads){
        
    }
    
    public function injectAdminMenu($key, &$menu){
        $links = Plugin::get('settings')->get('global.backend.menu.'.$key);
        if(is_array($links))
            foreach($links as $link){
                $menu[] = array('text' => ri($link['text']), 'link' => $link['link']);                
            }
    }
}