<?php

require(__DIR__.'/../../zepluf/app/bootstrap.php');

$autoLoadConfig[200][] = array(
    'autoType' => 'require',
    'loadFile' => $container->getParameter('kernel.root_dir') . '/plugins/riPlugin/init_includes.php'
);

$autoLoadConfig[999][] = array(
    'autoType' => 'require',
    'loadFile' => $container->getParameter('kernel.root_dir') . '/plugins/riPlugin/frontend_routing.php'
);