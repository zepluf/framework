<?php
/**
 * intializes all the important variables that ZePLUF needs
 */

/**
 * includes the global functions that we need
 */

if(!isset($environment)) {
    $environment = "prod";
}

use Symfony\Component\ClassLoader\ApcClassLoader;

$loader = require_once __DIR__ . '/bootstrap.php.cache';

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
// TODO: remove constants
$container->get("environment")->setEnvironment($environment);
if (defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG == true) {
    $container->get("environment")->setSubEnvironment("backend");
    $container->get("environment")->setTemplate($container->getParameter('store.backend.current_template'));
} else {
    $container->get("environment")->setSubEnvironment("frontend");
    $container->get("environment")->setTemplate($container->getParameter('store.frontend.current_template'));
}

$container->get("plugin")->loadPluginsSettings();

// path to zencart dir, edit if you place zencart elsewhere
define("ZENCART_DIR", $container->getParameter("store.zencart_dir"));
// zencart admin folder name
define("ZENCART_ADMIN_DIR", $container->getParameter("store.zencart_backend_dir"));
