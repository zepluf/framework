<?php 

namespace plugins\riPlugin;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Route;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;


class Plugin{
	private static 
	    $loaded = array(), 
	    $info = array(),
	    $version,
	    $container, 
	    $loader, 
	    $routes, 
	    $is_admin = false,
	    $cache_folder, 
	    $cache_file;
	
	const GREATER = 1, EQUAL = 0, LESS = -1;
	
	public static function init($loader, $container, $routes){		
		self::$container = $container;		
		self::$loader = $loader;
		self::$routes = $routes;
		
		self::$cache_folder = __DIR__ . '/../../../cache/riPlugin/';
		if(defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG == true){
	        self::$is_admin = true;
	        self::$cache_file = 'settings.backend.cache';
	    }
	    else 
	        self::$cache_file = 'settings.frontend.cache';
	        
        // check version
        if((int)PROJECT_VERSION_MAJOR > 1 || (int)PROJECT_VERSION_MINOR > 0)
            self::$version = PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR;

        Yaml::enablePhpParsing();
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

				// register the plugin main file
				self::registerCore($plugin, $plugin_name);

				// load plugin's settings
				if(!self::get('settings')->isInitiated()){
    				$settings = self::loadSettings($plugin, $config_path);
				}
				else {
				    $settings = self::get('settings')->get($plugin);
				    //self::$container->get('dispatcher')->dispatch('test', new \Symfony\Component\EventDispatcher\Event());
				}
				
				if(!empty($settings)){
				    
                    // set routes
					if(isset($settings['routes'])){
						foreach($settings['routes'] as $key => $route){
							$route = array_merge(array('pattern' => '', 'defaults' => array(), 'requirements' => array(), 'options' => array()), $route);							
							self::$routes->add($key, new Route($route['pattern'], $route['defaults'], $route['requirements'], $route['options']));
						}						
					}
					
				};
				    
				self::loadTranslations($plugin_path, 'en');
				// init 				
				if(Plugin::get($plugin_name) !== false){
				    Plugin::get($plugin_name)->init();
				}
				
				if(file_exists($plugin_path.'/lib/auto_loaders.php')){
				    require_once($plugin_path.'/lib/auto_loaders.php');
				}
				
				
				// set the dispatcher
				$event = new PluginEvent();				
        		self::$container->get('dispatcher')->dispatch(PluginEvents::onLoadEnd, $event->setPlugin($plugin)->setSettings($settings));
				
				self::$loaded[] = $plugin; 				
			}
		}		
	}

    private static function registerCore($plugin_name, $plugin_class){
        if(file_exists(__DIR__.'/../../' . $plugin_name . '/' . $plugin_class . '.php')){
            self::$loader->addNamespace(
                'plugins\\' . $plugin_name , realpath(__DIR__.'/../../' . $plugin_name . '') . '/@plugins\\' . $plugin_name
            );
            self::$container->register($plugin_class, 'plugins\\'.$plugin_name.'\\'.$plugin_class);
        }
    }

	/**
	 * 
	 * Load settings from yaml files, load local settings as well
	 * @param string $path
	 * @param string $file
	 */
	public function loadSettings($root, $config_path, $file = 'settings.yaml'){
	    $settings = array();	
	    if(file_exists($config_path.$file))
    	    $settings = Yaml::parse($config_path . $file);
    	
    	if(file_exists($config_path . 'local.yaml')){
    	    $local = (array)Yaml::parse($config_path . 'local.yaml');
    	    $settings = empty($settings) ? $local : arrayMergeWithReplace($settings, $local);
    	}

        self::get('settings')->set($root, $settings);
        if(isset($settings['global'])) self::get('settings')->set('global', $settings['global'], true);

    	return $settings;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $plugin_path
	 * @param string $fallback
	 */
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
	    if(!self::$container->has($service)){
	        // see if we should try to load this plugin
	        //list($plugin, $class) = explode('.', $service);
	        //if(!self::isLoaded($plugin)) self::load($plugin);
	        return false;
	        //if(!self::$container->has($service)) return false;
	    }
		    
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
	    return in_array($plugin, self::get('settings')->get('framework.activated'));
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $plugin
	 */
    public function isInstalled($plugin){
	    return in_array($plugin, self::get('settings')->get('framework.installed'));
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $plugin
	 */
	public function info($plugin){
	    if(!isset(self::$info[$plugin]))
	        if(file_exists($file_path = __DIR__ . '/../../' . $plugin . '/plugin.xml'))
                self::$info[$plugin] = new \SimpleXMLElement(file_get_contents($file_path));
	        else 
	            self::$info[$plugin] = false;
	            
        return self::$info[$plugin];     
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $plugin
	 */
	public function deactivate($plugin){
	    $settings = Yaml::parse(__DIR__ .'/../../local.yaml');
	    	    
	    if(in_array($plugin, $settings['activated'])){	    
	        if(Plugin::get($plugin) === false || Plugin::get($plugin)->deactivate() !== false){  
    	        self::get('riUtility.Collection')->removeValue($settings['activated'], $plugin);
    	        self::get('riUtility.Collection')->removeValue($settings['frontend']['preload'], $plugin);
    	        self::get('riUtility.Collection')->removeValue($settings['backend']['preload'], $plugin);
    	        
    	        self::saveSettings('framework', $settings);
    	        
    	        // add menu for ZC 1.5.0 >
    	        if(function_exists('zen_deregister_admin_pages')){
        	        if(($menus = self::get('settings')->get($plugin . '.global.backend.menu', null)) != null){	            	           
        	            foreach ($menus as $menu_key => $sub_menus)
        	                foreach($sub_menus as $menu){
        	                    $id = preg_replace("/[^A-Za-z0-9\s\s+\-]/", "_", $menu['link']);	                    
        	                    zen_deregister_admin_pages('ZEPLUF_' . $id);
        	                }	                
        	        }
    	        }
	        }
	    }
	        	        	    
	    return true;
	}		
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $plugin
	 */
	public function activate($plugin){	    
	    $settings = Yaml::parse(__DIR__ .'/../../local.yaml');
	    
	    if(!is_array($settings))
            $settings = array();

        if(!isset($settings['activated']))
            $settings['activated'] = array();

	    if(!in_array($plugin, $settings['activated'])){
	        if(Plugin::get($plugin) === false || Plugin::get($plugin)->activate() !== false){
    	        $settings['activated'][] = $plugin;
    	        
    	        // we will put into the load
        	    $info = Plugin::info($plugin);
        	    
        	    // check dependencies first
                if(isset($info->dependencies->plugins)){
                    $error = false;
                    foreach($info->dependencies->plugins->plugin as $dependent_plugin){
                        if(!self::isInstalled($dependent_plugin->codename)){
                            $error = true;
                            self::get('riLog.Logs')->add(array(
                                'message' => ri('Plugin %plugin% min version %min% is required', array(
                                    '%plugin%' => $dependent_plugin->codename,
                                    '%min%' => $dependent_plugin->min)
                                )));
                        }

                        elseif(!self::isActivated($dependent_plugin->codename) || self::compareVersions($info->release, $dependent_plugin->min) == self::LESS){
                            // we need to check the version

                            $error = true;
                            self::get('riLog.Logs')->add(array(
                            'message' => ri('Plugin %plugin% min version %min% is required', array(
                                '%plugin%' => $dependent_plugin->codename,
                                '%min%' => $dependent_plugin->min)
                            )));

                        }
                    }

                    if($error) return false;
                }

        	    if($info->preload->frontend == 'true'){
        	        if(!isset($settings['frontend']['preload'])) $settings['frontend']['preload'] = array();
        	        self::get('riUtility.Collection')->insertValue($settings['frontend']['preload'], $plugin);
        	    }    	        
        	    if($info->preload->backend == 'true'){
        	        if(!isset($settings['backend']['preload'])) $settings['backend']['preload'] = array();
        	        self::get('riUtility.Collection')->insertValue($settings['backend']['preload'], $plugin);
        	    }    	    
        	        
    	        self::saveSettings('framework', $settings);
    	        	        	       
    	        // add menu for ZC 1.5.0 >
    	        if(function_exists('zen_register_admin_page')){
    	            self::load($plugin);	        
        	        if(($menus = self::get('settings')->get($plugin . '.global.backend.menu', null)) != null){	            	           
        	            foreach ($menus as $menu_key => $sub_menus)
        	                foreach($sub_menus as $menu){
        	                    $id = preg_replace("/[^A-Za-z0-9\s\s+\-]/", "_", $menu['link']);	                    
        	                    zen_register_admin_page('ZEPLUF_' . $id, 'ZEPLUF_MENU_NAME_' . $id, 'ZEPLUF_MENU_URL_' . $id, '', $menu_key, 'Y', 1);
        	                }	                
        	        }
    	        }
	        }
	    }
	    return true;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $plugin
	 */
	public function install($plugin){    
	    $settings = Yaml::parse(__DIR__ .'/../../local.yaml');	      
	    
	    $plugin_path = realpath(__DIR__.'/../../'.$plugin.'/') . '/';
	    
	    $plugin_class = ucfirst($plugin);

        self::registerCore($plugin, $plugin_class);

	    if(Plugin::get($plugin_class) !== false){
    	    if(!in_array($plugin, $settings['installed'])){
    	        $settings['installed'][] = $plugin;
    	        if(Plugin::get($plugin_class)->install()){
        	        // we will put into the load
            	    self::get('riUtility.Collection')->insertValue($settings['installed'], $plugin);
            	    self::saveSettings('framework', $settings);
            	    return true;
    	        }    	    
    	    }	        
		}
		else{		    
		    self::get('riUtility.Collection')->insertValue($settings['installed'], $plugin);
		    self::saveSettings('framework', $settings);
            return true;
		}
		
	    return false;
	   
	}
	
	public function uninstall($plugin){
	    $settings = Yaml::parse(__DIR__ .'/../../local.yaml');
	    
	    $plugin_path = realpath(__DIR__.'/../../'.$plugin.'/') . '/';
	    
	    $plugin_class = ucfirst($plugin);
	    
	    if(Plugin::get($plugin) !== false){	        
	        if(in_array($plugin, $settings['installed'])){    	        
    	        if(Plugin::get($plugin_class)->uninstall()){
        	        // we will put into the load
            	    self::get('riUtility.Collection')->removeValue($settings['installed'], $plugin);
            	    self::saveSettings('framework', $settings);
            	    
            	    self::deactivate($plugin);
            	    return true;
    	        }    	    
    	    }
	    }else{
            self::get('riUtility.Collection')->removeValue($settings['installed'], $plugin);
            self::saveSettings('framework', $settings);
            
            self::deactivate($plugin);
            return true;	        
	    }
	    
	    return false;
	}
	
	public function isAdmin(){
	    return self::$is_admin;        
	}
	
	/**
	 * 
	 * save settings into cache file ...
	 */
	public function loadCacheSettings(){      
        if(file_exists(self::$cache_folder . self::$cache_file)){
            self::get('settings')->init(unserialize(file_get_contents(self::$cache_folder . self::$cache_file)));    
            return true;
        }
        return false;
	}
	
	/**
	 * 
	 * save settings into cache file ...
	 */
    public function saveCacheSettings(){        	
        $settings = self::get('settings')->get();    
	    self::get('riUtility.File')->write(self::$cache_folder . self::$cache_file, serialize($settings));	    
	}
	
	public function saveSettings($plugin = 'framework', $settings = array()){
	    
	    if($plugin == 'framework'){	        
	        $config_path = __DIR__ .'/../../';
	    }
	    else
	        $config_path = __DIR__ .'/../../' . $plugin . '/config/';
	        
	    if(empty($settings)){    
            $all_settings = self::get('settings')->get($plugin); 
            	        
    	    $default_settings = Yaml::parse(__DIR__ .'/../../settings.yaml');
    	    
    	    $settings = self::get('riUtility.Collection')->multiArrayDiff($all_settings, $default_settings);    	    
	    }
	    
	    // put into local.yaml
	    file_put_contents($config_path . 'local.yaml', Yaml::dump($settings));
	    
	    // reset cache
	    self::get('riCache.Cache')->remove('settings.backend.cache', self::$cache_folder);
	    self::get('riCache.Cache')->remove('settings.frontend.cache', self::$cache_folder);
	}
	
    /**
     * 
     * Enter description here ...
     * @param unknown_type $base_version
     * @param unknown_type $compare_version
     */
	private function compareVersions($base_version, $compare_version){
	   $base_version = (preg_split('/[^0-9a-z]/i', $base_version));
	   $compare_version = (preg_split('/[^0-9a-z]/i', $compare_version));

	   foreach($base_version as $key => $value){
	       if($value > $compare_version[$key])
	           return self::GREATER;
	       elseif($value < $compare_version[$key])
	           return self::LESS;
	   }
	   
	   $count_base_version = count($base_version);
	   $count_compare_version = count($compare_version);
	   
	   if($count_base_version == $count_compare_version)
	       return self::EQUAL;
	   
	   if($count_base_version > $count_compare_version)
	       return self::GREATER;
	       
	   return self::LESS;
	}	
}