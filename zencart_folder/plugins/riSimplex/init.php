<?php 

use plugins\riPlugin\Plugin;
use Symfony\Component\HttpFoundation\Request;

Plugin::load(array('riSimplex'));

$request = Request::createFromGlobals();

$response = Plugin::get('riSimplex.Framework')->handle($request);