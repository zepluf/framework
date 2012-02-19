<?php 

use plugins\riPlugin\Plugin;
use Symfony\Component\HttpFoundation\Request;

Plugin::load(array('riSimplex'));

$request = Request::createFromGlobals();

$container->setParameter('request', $request);

$response = Plugin::get('riSimplex.Framework')->handle($request);