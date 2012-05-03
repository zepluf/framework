<?php 
require('includes/application_top.php');
require('plugins/riSimplex/init.php');

$content = $response->getContent();
$response->setContent($content);
$response->send();