<?php
namespace plugins\riZCAdmin;

use plugins\riCore\PluginCore;


class RiZCAdmin extends PluginCore{
    public function init(){

        if(IS_ADMIN_FLAG){
            global $autoLoadConfig;
            $autoLoadConfig[200][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/lib/init_includes.php');
        }

    }

}