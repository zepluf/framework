<?php 

use plugins\riPlugin\Plugin;

Plugin::load(array('riSimplex'));

$container->setParameter('request', $request);

$response = Plugin::get('riSimplex.Framework')->handle($request);