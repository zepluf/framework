<?php 

namespace plugins\riPlugin;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Route;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;


class Plugin{
	private static $loaded = array(), $info = array();
	private static $container, $loader, $routes;
	
	public static function init($loader, $container, $routes){		
		self::$container = $container;		
		self::$loader = $loader;
		self::$routes = $routes;
	}
	
	public static function getLoaded(){
	    return self::$loaded;    
	}
	
	public static function isLoaded($plugin){
	    return in_array($plugin, self::$loaded);    
	}
	
	public static function load($plugins){
		if(!is_array($plugins)) $plugins = array($plugins);
		foreach ($plugins as $plugin){
			if(!in_array($plugin, self::$loaded)){				
			    $plugin_path = realpath(__DIR__.'/../../'.$plugin.'/') . '/';
			    
			    $plugin_name = ucfirst($plugin);
			    
				$config_path = $plugin_path.'config/';
								
				foreach (glob($config_path."*.php") as $file) { 
					include($file);
				}
				
				// add config for class loader
				if(is_dir($plugin_path."lib"))
				self::$loader->addConfig($plugin_path."lib");							
                if(is_dir($plugin_path."vendor"))
				self::$loader->addConfig($plugin_path."vendor");
				
				if(file_exists($config_path.'services.xml')){
					$loader = new XMLFileLoader(self::$container, new FileLocator($config_path));				
        			$loader->load('services.xml');	
				}
				else{
					foreach (glob($plugin_path."/lib/*.php") as $file) { 
						$filename = basename($file, '.php');
						self::$container->register($plugin.'.'.$filename, 'plugins\\'.$plugin.'\\'.$filename);						    		
					}	
				}

				Yaml::enablePhpParsing();
				// load plugin's settings
				if(!self::get('riPlugin.Settings')->isInitiated()){
    				$settings = array();
    				if(file_exists($config_path.'settings.yaml')){
    					$settings = Yaml::parse($config_path.'settings.yaml');
    					
    					// set routes
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
				}
				else 
				    $settings = self::get('riPlugin.Settings')->get($plugin);
				    
				self::loadTranslations($plugin_path, 'en');
				// init 				
				if(file_exists($plugin_path.$plugin_name.'.php')){
				    require($plugin_path.$plugin_name.'.php');
				    $class_name = "plugins\\$plugin\\$plugin_name";
				    $plugin_object = new $class_name(self::$container->get('dispatcher'), self::$container);
				    $plugin_object->init();
				}
				
				if(file_exists($plugin_path.'/lib/auto_loaders.php')){
				    require($plugin_path.'/lib/auto_loaders.php');
				}
				
				
				// set the dispatcher
				$event = new PluginEvent();				
        		self::$container->get('dispatcher')->dispatch(PluginEvents::onLoadEnd, $event->setPlugin($plugin)->setSettings($settings));
				
				self::$loaded[] = $plugin; 				
			}
		}		
	}
	
	private static function loadTranslations($plugin_path, $fallback)
    {        
        if(is_dir($plugin_path . 'translations')){
            $translator = self::$container->get('translator');        
            // Discover translation directories
            $dirs = array();
            if(is_dir($dir = $plugin_path . 'translations'))
                $dirs[] = $dir;
            /*
            if (is_dir($dir = $container->getParameter('kernel.root_dir').'/Resources/translations')) {
                $dirs[] = $dir;
            }
    		*/
                
            // Register translation resources
            if ($dirs) {
                $finder = new Finder();
                $finder->files()->filter(function (\SplFileInfo $file) {
                    return 2 === substr_count($file->getBasename(), '.') && preg_match('/\.\w+$/', $file->getBasename());
                })->in($dirs);
                foreach ($finder as $file) {
                    // filename is domain.locale.format
                    list($domain, $locale, $format) = explode('.', $file->getBasename(), 3);
                    
                    // we have to add resource right away or it will be too late
                    $translator->addResource($format, (string) $file, $locale, $domain);        
                }                        
            }
        }                
    }
	
	public static function getContainer(){
		return self::$container;
	}
	
	public static function get($service){
	    if(!self::$container->has($service)) return false;
	    	    
		$service = self::$container->get($service);		
		if (null != $service && $service instanceof \Symfony\Component\DependencyInjection\ContainerAwareInterface) {
            $service->setContainer(self::$container);
        }else{
        	
        }
		return $service;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $plugin
	 */
	public function isActivated($plugin){
	    return in_array($plugin, self::get('riPlugin.Settings')->get('framework.activated'));
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $plugin
	 */
	public function info($plugin){
	    if(!isset(self::$info[$plugin]))
	        if(file_exists($file_path = __DIR__ . '/../../' . $plugin . '/plugin.xml'))
                self::$info[$plugin] = \SimpleXMLElement(file_get_contents($file_path));
	        else 
	            self::$info[$plugin] = false;
	            
        return self::$info[$plugin];     
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $plugin
	 */
	public function toggle($plugin){
	    $settings = self::get('riPlugin.Settings')->get('framework');
	    
	    $activated = false;
	    if(!in_array($plugin, $settings['activated'])){
	        $settings['activated'][] = $plugin;
	        
	        // we will put into the load
    	    $info = Plugin::info($plugin);
    	    if($info->preload->frontend === true)
    	        self::get('riUtility.Collection')->insertValue($settings['frontend']['preload'], $plugin);    	        
    	    if($info->preload->backend === true)
    	        self::get('riUtility.Collection')->insertValue($settings['backend']['preload'], $plugin);
    	    if($info->preload->global === true)
    	        self::get('riUtility.Collection')->insertValue($settings['global']['preload'], $plugin);
    	        
	        $activated = true;
	    }
	    else {
	        $settings['activated'] = self::get('riUtility.Collection')->removeValue($settings['activated'], $plugin);
	        self::get('riUtility.Collection')->removeValue($settings['frontend']['preload'], $plugin);
	        self::get('riUtility.Collection')->removeValue($settings['backend']['preload'], $plugin);
	        self::get('riUtility.Collection')->removeValue($settings['global']['preload'], $plugin);
	    }
	        	        
	    file_put_contents(__DIR__ .'/../../settings.yaml', Yaml::dump($settings));
	    
	    self::get('riCache.Cache')->remove('settings.backend.cache', '/riPlugin/');
	    self::get('riCache.Cache')->remove('settings.frontend.cache', '/riPlugin/');
	    return $activated;
	}
}