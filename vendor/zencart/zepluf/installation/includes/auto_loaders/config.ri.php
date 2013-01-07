<?php

require(__DIR__.'/../../zepluf/app/bootstrap.php');

// We need to modify the default load order of Zen. Language class must be loaded first
$autoLoadConfig[80][] = array('autoType'=>'init_script', 'loadFile'=> 'init_languages.php');
foreach ($autoLoadConfig[110] as $key => $value){
    if($value['loadFile'] == 'init_languages.php'){
        unset($autoLoadConfig[110][$key]);
        break;
    }
}

$autoLoadConfig[80][] = array(
    'autoType' => 'require',
    'loadFile' => $container->getParameter('kernel.root_dir') . '/frontend_routing.php'
);

$autoLoadConfig[200][] = array(
    'autoType' => 'require',
    'loadFile' => $container->getParameter('kernel.root_dir') . '/init_includes.php'
);