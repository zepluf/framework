<?php 

use plugins\riPlugin\Plugin;

Plugin::load(array('riSimplex'));

$container->setParameter('request', $request);
try{
    $response = Plugin::get('riSimplex.Framework')->handle($request, Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST, false);
}catch (Exception $e){
    // do something?
    exit('something went wrong with the routing');
}