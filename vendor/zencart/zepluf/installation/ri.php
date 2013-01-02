<?php 
require('includes/application_top.php');

try{
    $response = $kernel->handle($request, Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST, false);
}catch (Exception $e){
    // do something?
    echo $e->getMessage();
    exit('something went wrong with the routing');
}

$content = $response->getContent();
$response->setContent($content);
$response->send();

$kernel->terminate($request, $response);