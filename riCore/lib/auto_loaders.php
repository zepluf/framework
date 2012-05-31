<?php
/**
 * @package Pages
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: config.ssu.php 319 2010-02-22 11:04:33Z yellow1912 $
 */
//if(!IS_ADMIN_FLAG){
    global $autoLoadConfig;
    // we want to include the loader into the view for easy access, we need to do it after the template is loaded
    $autoLoadConfig[200][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/init_includes.php');
//}