<?php 
require_once('riPlugin/lib/common.php');
require_once('riCore/vendor/zenmagick/lib/base/classloader/ClassLoader.php');

// load the class loader and dependency injection component
$class_loader = new zenmagick\base\classloader\ClassLoader();

$class_loader->addNamespaces(array(	
	'plugins\riPlugin' => __DIR__.'/riPlugin/lib@plugins\riPlugin',
    'plugins\riCore' => __DIR__.'/riCore/lib@plugins\riCore',
));

$class_loader->addNamespace('Symfony',__DIR__.'/riCore/vendor/symfony/src');

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

Plugin::get('settings')->load('theme');

Plugin::get('settings')->load('framework', __DIR__ . '/');
$framework_settings = Plugin::get('settings')->get('framework');

// if this is the first time ZePLUF is loaded we need to do some init
if(!$framework_settings['initalized']){
    foreach ($framework_settings['core'] as $plugin){
        Plugin::install($plugin);
        Plugin::load($plugin);
        Plugin::activate($plugin);
    }

    // if this is the first time
    Plugin::get('settings')->set('framework.initalized', true);
    Plugin::get('settings')->saveLocal();
}

// a hack for zen
if(Plugin::isAdmin()){
	if(is_array($framework_settings['backend']['preload'])) Plugin::load($framework_settings['backend']['preload']);
}
else{
	if(is_array($framework_settings['frontend']['preload'])) Plugin::load($framework_settings['frontend']['preload']);
}

// init the view to be used globally in ZC
$riview = Plugin::get('view');
