<?php
/**
 * intializes all the important variables that ZePLUF needs
 */

/**
 * includes the global functions that we need
 */

$environment = "prod";
$coreDir = __DIR__ . '/../';

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/bootstrap.php.cache';

$loader->add('plugins', __DIR__);

// Use APC for autoloading to improve performance
// Change 'sf2' by the prefix you want in order to prevent key conflict with another application
/*
$loader = new ApcClassLoader('sf2', $loader);
$loader->register(true);
*/

require_once 'AppKernel.php';
$kernel = new AppKernel($environment, false);
$kernel->loadClassCache();

$kernel->boot();

$container = $kernel->getContainer();

// set the environment
$container->get("environment")->setEnvironment($environment);
if (defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG == true) {
    $container->get("environment")->setSubEnvironment("backend");
}
else {
    $container->get("environment")->setSubEnvironment("frontend");
}

$container->get("plugin")->setLoader($loader);
$container->get("plugin")->loadPlugins($container);

// some global vars to be used on Zencart as well
$request = Request::createFromGlobals();
$core_event = $container->get('storebundle.core_event');

$view = $container->get("view");