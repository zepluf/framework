<?php 
require_once('riPlugin/lib/common.php');
require_once(__DIR__.'/../zenmagick/lib/base/classloader/ClassLoader.php');

// load the class loader and dependency injection component
$class_loader = new zenmagick\base\classloader\ClassLoader();

$class_loader->addNamespaces(array(	
	'plugins\riPlugin' => __DIR__.'/riPlugin/lib@plugins\riPlugin',	
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
$container->register('riPlugin.Settings', 'plugins\\riPlugin\\Settings');
Plugin::init($class_loader, $container, $routes);

// preload several core plugins
Plugin::load(array('riCore', 'riCache'));

$is_admin = false;
$cache_folder = '/riPlugin';
$cache_file = 'settings.frontend.cache';
if(defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG == true){
    $is_admin = true;
    $cache_file = 'settings.backend.cache';
}

if(($settings = Plugin::get('riCache.Cache')->read($cache_file, $cache_folder)) !== false){
    Plugin::get('riPlugin.Settings')->init(unserialize($settings));    
    $framework_settings = $container->get('riPlugin.Settings')->get('framework');
}
else{
    $framework_settings = Plugin::loadSettings(__DIR__ . '/');
    Plugin::get('riPlugin.Settings')->set('framework', $framework_settings);
}

if(is_array($framework_settings['global']['preload'])) Plugin::load($framework_settings['global']['preload']);

// a hack for zen
if($is_admin){
	if(is_array($framework_settings['backend']['preload'])) Plugin::load($framework_settings['backend']['preload']);
}
else{
	if(is_array($framework_settings['frontend']['preload'])) Plugin::load($framework_settings['frontend']['preload']);
}

if($settings === false){
    Plugin::get('riCache.Cache')->write($cache_file, $cache_folder, serialize($container->get('riPlugin.Settings')->get()));
}
// init the view to be used globally in ZC
$riview = Plugin::get('riCore.View');