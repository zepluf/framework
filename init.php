<?php 
require_once('riPlugin/lib/common.php');
require_once(__DIR__.'/../zenmagick/lib/base/classloader/ClassLoader.php');

// load the class loader and dependency injection component
$class_loader = new zenmagick\base\classloader\ClassLoader();

$class_loader->addNamespaces(array(	
	'plugins\riPlugin' => __DIR__.'/riPlugin/lib@plugins\riPlugin',
    'plugins\riCore' => __DIR__.'/riCore/lib@plugins\riCore',
));

$class_loader->addNamespace('Symfony',__DIR__.'/../zenmagick/vendor/symfony/src');

//$loader->useIncludePath(true);

$class_loader->register(true);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
//use Symfony\Component\Translation\Loader\MoFileLoader;
//use Symfony\Component\Translation\Loader\PoFileLoader;
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

if(Plugin::loadCacheSettings()){       
    $framework_settings = $container->get('settings')->get('framework');
}
else{
    $framework_settings = Plugin::loadSettings('framework',__DIR__ . '/');
}

// a hack for zen
if(Plugin::isAdmin()){
	if(is_array($framework_settings['backend']['preload'])) Plugin::load($framework_settings['backend']['preload']);
}
else{
	if(is_array($framework_settings['frontend']['preload'])) Plugin::load($framework_settings['frontend']['preload']);
}

if(!Plugin::get('settings')->isInitiated()){
    Plugin::saveCacheSettings();
}
// init the view to be used globally in ZC
$riview = Plugin::get('riCore.View');