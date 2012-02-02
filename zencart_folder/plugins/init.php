<?php 

require_once('riPlugin/lib/common.php');
require_once(__DIR__.'/../zenmagick/lib/base/classloader/ClassLoader.php');

// load the class loader and dependency injection component
$loader = new zenmagick\base\classloader\ClassLoader();

//$loader->registerNamespace('plugins',DIR_FS_CATALOG);
$loader->addNamespaces(array(	
	'plugins\riPlugin' => __DIR__.'/riPlugin/lib@plugins\riPlugin',	
));

$loader->addNamespace('Symfony',__DIR__.'/../zenmagick/vendor/symfony/src');

//$loader->useIncludePath(true);

$loader->register(true);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Routing;
use plugins\riPlugin\Container;
use plugins\riPlugin\Plugin;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\EventDispatcher\Event;
$container = new Container();		

//use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
//use Symfony\Component\Config\FileLocator;

$container->register('dispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher');

$container->register('riPlugin.Settings', 'plugins\\riPlugin\\Settings');

$routes = new Routing\RouteCollection();

Plugin::init($loader, $container, $routes);

$settings = Yaml::parse(__DIR__.'/settings.yaml');
if(is_array($settings['global']['preload'])) Plugin::load($settings['global']['preload']);

// a hack for zen
if(defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG == true){
	if(is_array($settings['backend']['preload'])) Plugin::load($settings['backend']['preload']);
}
else{
	if(is_array($settings['frontend']['preload'])) Plugin::load($settings['frontend']['preload']);
}