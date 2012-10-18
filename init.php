<?php
/**
 * intializes all the important variables that ZePLUF needs
 */

/**
 * includes the global functions that we need
 */
require_once('riPlugin/lib/common.php');

/**
 * loads ZenMagick's loader
 */
require_once('riCore/vendor/zenmagick/lib/base/classloader/ClassLoader.php');

// load the class loader and dependency injection component
$class_loader = new zenmagick\base\classloader\ClassLoader();

$class_loader->addNamespaces(array(
    'plugins' => __DIR__ . '/..',
	'plugins\riPlugin' => __DIR__.'/riPlugin/lib@plugins\riPlugin',
    'plugins\riCore' => __DIR__.'/riCore/lib@plugins\riCore',
    'Symfony' => __DIR__.'/riCore/vendor/symfony/src'
));

$class_loader->register(true);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use plugins\riPlugin\Container;
use plugins\riPlugin\Plugin;

$container = new Container();		

$routes = new Routing\RouteCollection();

$container->setParameter('container', $container);
$container->setParameter('routes', $routes);
$container->setParameter('charset', 'UTF-8'); 

// load the base services
$xml_loader = new XMLFileLoader($container, new FileLocator(__DIR__));				
$xml_loader->load('services.xml');	

$request = Request::createFromGlobals();
$container->setParameter('request', $request);

// register settings service
$container->register('settings', 'plugins\\riCore\\Settings');
Plugin::init($class_loader, $container, $routes);

// init the view to be used globally in ZC
$riview = Plugin::get('view');
