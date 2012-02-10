<?php 

namespace plugins\riPlugin;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Route;
use Symfony\Component\DependencyInjection\Reference;


class Plugin{
	private static $loaded = array();
	private static $container, $loader, $routes;
	
	public static function init($loader, $container, $routes){		
		self::$container = $container;		
		self::$loader = $loader;
		self::$routes = $routes;
	}
	
	public static function load($plugins){
		if(!is_array($plugins)) $plugins = array($plugins);
		foreach ($plugins as $plugin){
			if(!in_array($plugin, self::$loaded)){
				
			    $plugin_path = __DIR__.'/../../'.$plugin.'/';
			    
			    $plugin_name = ucfirst($plugin);
			    
				$config_path = $plugin_path.'config/';
								
				foreach (glob($config_path."*.php") as $file) { 
					include($file);
				}
				
				self::$loader->addConfig(__DIR__.'/../../'.$plugin."/lib");							
							    
				if(file_exists($config_path.'services.xml')){
					$loader = new XMLFileLoader(self::$container, new FileLocator($config_path));				
        			$loader->load('services.xml');	
				}
				else{
					foreach (glob(__DIR__.'/../../'.$plugin."/lib/*.php") as $file) { 
						$filename = basename($file, '.php');
						self::$container->register($plugin.'.'.$filename, 'plugins\\'.$plugin.'\\'.$filename);						    		
					}	
				}

				// load plugin's settings
				if(file_exists($config_path.'settings.yaml')){
					$settings = Yaml::parse($config_path.'settings.yaml');
					
					if(isset($settings['routes'])){
						foreach($settings['routes'] as $key => $route){
							$route = array_merge(array('pattern' => '', 'defaults' => array(), 'requirements' => array(), 'options' => array()), $route);							
							self::$routes->add($key, new Route($route['pattern'], $route['defaults'], $route['requirements'], $route['options']));
						}						
					}
					
					//self::$container->get('dispatcher')->dispatch('test', new \Symfony\Component\EventDispatcher\Event());
					if(isset($settings['global'])) self::get('riPlugin.Settings')->set('global', $settings['global'], true); 
					
					self::get('riPlugin.Settings')->set($plugin, $settings);					
				};
				
				if(file_exists($plugin_path.$plugin_name.'.php')){
				    require($plugin_path.$plugin_name.'.php');
				    $class_name = "plugins\\$plugin\\$plugin_name";
				    $plugin_object = new $class_name(self::$container->get('dispatcher'), self::$container);
				    $plugin_object->init();
				}
				
				    
				self::$loaded[] = $plugin; 				
			}
		}		
	}
	
	public static function getContainer(){
		return self::$container;
	}
	
	public static function get($service){
		$service = self::$container->get($service);		
		if (null != $service && $service instanceof \Symfony\Component\DependencyInjection\ContainerAwareInterface) {
            $service->setContainer(self::$container);
        }else{
        	
        }
		return $service;
	}
}