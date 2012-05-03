<?php 
require_once('riPlugin/lib/common.php');
require_once(__DIR__.'/../zenmagick/lib/base/classloader/ClassLoader.php');

// load the class loader and dependency injection component
$loader = new zenmagick\base\classloader\ClassLoader();

$loader->addNamespaces(array(	
	'plugins\riPlugin' => __DIR__.'/riPlugin/lib@plugins\riPlugin',	
));

$loader->addNamespace('Symfony',__DIR__.'/../zenmagick/vendor/symfony/src');

//$loader->useIncludePath(true);

$loader->register(true);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Request;

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

use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Loader\PoFileLoader;

Plugin::init($loader, $container, $routes);

$settings = Yaml::parse(__DIR__.'/settings.yaml');
$container->setParameter('locale', $settings['framework']['translator']['fallback']);

$request = Request::createFromGlobals();
$container->setParameter('request', $request);

if(is_array($settings['global']['preload'])) Plugin::load($settings['global']['preload']);

// a hack for zen
if(defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG == true){
	if(is_array($settings['backend']['preload'])) Plugin::load($settings['backend']['preload']);
}
else{
	if(is_array($settings['frontend']['preload'])) Plugin::load($settings['frontend']['preload']);
}

// init the view to be used globally in ZC
$riview = Plugin::get('riCore.View');