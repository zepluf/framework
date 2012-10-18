<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace plugins\riPlugin;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Route;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;

/**
 * core class handling anything related to a plugin
 * also acts as the main service container
 */
class Plugin{

    /**
     * array of loaded plugins names
     *
     * @var array
     */
	private static $loaded = array();

    /**
     * array of plugins info
     *
     * @var array
     */
    private static $info = array();

    /**
     * current version
     *
     * @var
     */
    private static $version;

    /**
     * service container
     *
     * @var
     */
    private static $container;

    /**
     * class loader
     *
     * @var
     */
    private static $loader;

    /**
     * routes collection
     *
     * @var
     */
    private static $routes;

    /**
     * is admin?
     *
     * @var bool
     */
    private static $is_admin = false;

    /**
     * backend or frontend env?
     *
     * @var
     */
    private static $environment;

    /**
     * inits the Plugin container
     *
     * @static
     * @param $loader
     * @param $container
     * @param $routes
     */
	public static function init($loader, $container, $routes){		
		self::$container = $container;		
		self::$loader = $loader;
		self::$routes = $routes;

		if(defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG == true){
	        self::$is_admin = true;
            self::$environment = 'backend';
	    }
	    else
            self::$environment = 'frontend';

        // check version
        if((int)PROJECT_VERSION_MAJOR > 1 || (int)PROJECT_VERSION_MINOR > 0)
            self::$version = PROJECT_VERSION_MAJOR . '.' . PROJECT_VERSION_MINOR;

        Yaml::enablePhpParsing();

        // load framework settings
        self::get('settings')->load('framework', __DIR__ . '/../../');
        $framework_settings = self::get('settings')->get('framework');

        // a hack for zen
        if(self::isAdmin()){
            if(is_array($framework_settings['backend']['preload'])) Plugin::load($framework_settings['backend']['preload']);
        }
        else{
            if(is_array($framework_settings['frontend']['preload'])) Plugin::load($framework_settings['frontend']['preload']);
            // load theme settings
            self::get('settings')->loadTheme('frontend');
        }

        self::$container->get('dispatcher')->dispatch(PluginEvents::onInitEnd, new PluginEvent());
	}

    /**
     * setups ZePLUF
     *
     * @static
     * @param bool $force
     */
    public static function setup($force = false){
        // we should check if some folders are writtable

        if(!self::get('settings')->preCheck())
            die(sprintf("ZePLUF is using this folder %s to write cache files, please make it writeable!", self::get('settings')->getCacheRoot()));

        $local_folder = realpath(__DIR__ . '/../../');
        $local_file = $local_folder . '/' . 'local.yaml';
        if(file_exists($local_file) && !is_writable($local_file))
            die(sprintf("ZePLUF is using this file %s to write cache files, please create/make it writeable!", $local_file));
        elseif(!is_writable($local_folder))
            die(sprintf("ZePLUF is going to write local.yaml to this folder %s, please create/make the file writeable!", $local_folder));

        if($force){
            // we should remove all files in the cache
            self::get('settings')->resetCache();
            // then we should also remove the local.yaml
            @unlink($local_file);
        }

        $framework_settings = self::get('settings')->get('framework');
        // if this is the first time ZePLUF is loaded we need to do some init
        if(!$framework_settings['initalized']){
            foreach ($framework_settings['core'] as $plugin){
                self::install($plugin);
                self::load($plugin);
                self::activate($plugin);
            }

            // if this is the first time
            self::get('settings')->set('framework.initalized', true);
            self::get('settings')->saveLocal();
        }
    }

    /**
     * gets the array of loaded plugins
     *
     * @static
     * @return array
     */
	public static function getLoaded(){
	    return self::$loaded;    
	}

    /**
     * checks if a plugin is loaded
     *
     * @static
     * @param $plugin
     * @return bool
     */
	public static function isLoaded($plugin){
	    return in_array($plugin, self::$loaded);    
	}

    /**
     * loads a plugin or an array of plugin.
     * This will add all the classes to the the classes loader etc
     *
     * @static
     * @param $plugins
     */
	public static function load($plugins){
		if(!is_array($plugins)) $plugins = array($plugins);
		foreach ($plugins as $plugin){
			if(!in_array($plugin, self::$loaded)){				
			    $plugin_path = realpath(__DIR__.'/../../'.$plugin.'/') . '/';
			    
			    $plugin_name = ucfirst($plugin);
			    
				$config_path = $plugin_path.'config/';
								
				$config_files = glob($config_path."*.php");
				
				if($config_files !== false)
				foreach ($config_files as $file) { 
					include($file);
				}
				
				// add config for class loader
				if(is_dir($plugin_path."lib"))
				    self::$loader->addConfig($plugin_path."lib");							
                
				if(is_dir($plugin_path."vendor"))
				    self::$loader->addConfig($plugin_path."vendor");

                if(is_dir($plugin_path."tests"))
                    self::$loader->addConfig($plugin_path."tests");

                $loaded_services = false;
				if(file_exists($config_path.'services.xml')){
                    $loader = new XMLFileLoader(self::$container, new FileLocator($config_path));
                    $loader->load('services.xml');
                    $loaded_services = true;
                }

                if(file_exists($config_path.'local.xml')){
                    $loader = new XMLFileLoader(self::$container, new FileLocator($config_path));
                    $loader->load('local.xml');
                    $loaded_services = true;
                }

				if(!$loaded_services){
					foreach (glob($plugin_path."/lib/*.php") as $file) { 
						$filename = basename($file, '.php');

                        // we only register the filenames started with uppercase since these are class files
                        if(ctype_upper($filename[0]))
						    self::$container->register($plugin.'.'.$filename, 'plugins\\'.$plugin.'\\'.$filename);
					}	
				}

				// register the plugin main file
				self::registerCore($plugin, $plugin_name);

				// load plugin's settings

				$settings = self::get('settings')->load($plugin);
				//self::$container->get('dispatcher')->dispatch('test', new \Symfony\Component\EventDispatcher\Event());

				if(!empty($settings)){
                    // set routes
					if(isset($settings['routes'])){
                        $plugin_lc_name = strtolower($plugin_name);
						foreach($settings['routes'] as $key => $route){
							$route = array_merge(array('pattern' => '', 'defaults' => array(), 'requirements' => array(), 'options' => array()), $route);
                            if(strpos($route['pattern'], '/') !== false)
                                $route['pattern'] = $plugin_lc_name . $route['pattern'];
                            else
                                $route['pattern'] = $plugin_lc_name . '_' . $route['pattern'];

							self::$routes->add($plugin_lc_name . '_' . $key, new Route($route['pattern'], $route['defaults'], $route['requirements'], $route['options']));
						}						
					}
					
				};
				    
				self::loadTranslations($plugin_path, 'en');
				// init 				
				if(Plugin::get($plugin_name) !== false){
				    Plugin::get($plugin_name)->init();
				}
				
				// set the dispatcher
				$event = new PluginEvent();				
        		self::$container->get('dispatcher')->dispatch(PluginEvents::onPluginLoadEnd, $event->setPlugin($plugin)->setSettings($settings));
				
				self::$loaded[] = $plugin; 				
			}
		}		
	}

    /**
     * register the core plugins
     *
     * @static
     * @param $plugin_name
     * @param $plugin_class
     */
    private static function registerCore($plugin_name, $plugin_class){
        if(file_exists(__DIR__.'/../../' . $plugin_name . '/' . $plugin_class . '.php')){
            self::$loader->addNamespace(
                'plugins\\' . $plugin_name , realpath(__DIR__.'/../../' . $plugin_name . '') . '/@plugins\\' . $plugin_name
            );
            self::$container->register($plugin_class, 'plugins\\'.$plugin_name.'\\'.$plugin_class);
        }
    }

    /**
     * Load the translation files of the plugin
     * @static
     * @param $plugin_path
     * @param $fallback
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

    /**
     * Returns the container
     *
     * @static
     * @return mixed
     */
	public static function getContainer(){
		return self::$container;
	}		

    /**
     * Returns the specific service
     *
     * @static
     * @param $service
     * @return bool
     */
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
     * This function will uninstall a plugin
     * It will also call the plugins/pluginfolder/PluginClass->install() method of exists
     * @param $plugin
     * @return bool
     */
    public function install($plugin){
        $settings = self::get('settings')->get('framework');

        $plugin_class = ucfirst($plugin);

        self::registerCore($plugin, $plugin_class);

        if(Plugin::get($plugin_class) !== false){
            if(!isset($settings['installed']) || !in_array($plugin, $settings['installed'])){
                $settings['installed'][] = $plugin;

                if(Plugin::get($plugin_class) !== false && Plugin::get($plugin_class)->install()){
                     // we will put into the load

                    arrayInsertValue($settings['installed'], $plugin);

                    self::get('settings')->set('framework.installed', $settings['installed'], false);

                    return true;
                }
            }
        }
        else{
            arrayInsertValue($settings['installed'], $plugin);

            self::get('settings')->set('framework.installed', $settings['installed'], false);

            return true;
        }

        return false;
    }

    /**
     * This function will uninstall a plugin
     * It will also call the plugins/pluginfolder/PluginClass->uninstall() method of exists
     *
     * @param $plugin
     * @return bool
     */
    public function uninstall($plugin){
        $settings = self::get('settings')->get('framework');

        $plugin_class = ucfirst($plugin);

        // we need to load this plugin even if it has been de-activated
        self::load($plugin);

        if(!isset($settings['installed']) || in_array($plugin, $settings['installed'])){
            if(Plugin::get($plugin_class) !== false && Plugin::get($plugin_class)->uninstall()){
                // we will put into the load
                arrayRemoveValue($settings['installed'], $plugin);
                self::get('settings')->set('framework.installed', $settings['installed'], false);

                self::deactivate($plugin);
                return true;
            }
        }

        return false;
    }

	/**
     * Checks if the plugin is installed
     *
     * @param $plugin
     * @return bool
     */
    public function isInstalled($plugin){
	    return in_array($plugin, self::get('settings')->get('framework.installed', array()));
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
     * This function will activate a plugin
     * It will also call the plugins/pluginfolder/PluginClass->activate() method of exists
     *
     * @param $plugin
     * @return bool
     */
    public function activate($plugin){
        $settings = self::get('settings')->get('framework');

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

                        elseif(!self::isActivated($dependent_plugin->codename) || self::compareVersions($info->release, $dependent_plugin->min) == VERSION_LESS){
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
                    arrayInsertValue($settings['frontend']['preload'], $plugin);
                }
                if($info->preload->backend == 'true'){
                    if(!isset($settings['backend']['preload'])) $settings['backend']['preload'] = array();
                    arrayInsertValue($settings['backend']['preload'], $plugin);
                }

                // set back to settings
                self::get('settings')->set('framework', $settings, true);

                // add menu for ZC 1.5.0 >
                if(function_exists('zen_register_admin_page')){
                    self::load($plugin);
                    if(($menus = self::get('settings')->get($plugin . '.global.backend.menu', null)) != null){
                        foreach ($menus as $menu_key => $sub_menus)
                            foreach($sub_menus as $menu){
                                $id = md5($menu['link']);
                                zen_deregister_admin_pages($id);
                                zen_register_admin_page($id, 'ZEPLUF_NAME_' . $id, 'ZEPLUF_URL_' . $id, '', $menu_key, 'Y', 1);
                            }
                    }
                }
            }
        }

        $settings = self::get('settings')->load($plugin);
        return true;
    }

	/**
     * This function will deactivate a plugin
     * It will also call the plugins/pluginfolder/PluginClass->deactivate() method of exists
     *
     * @param $plugin
     * @return bool
     */
	public function deactivate($plugin){
        $settings = self::get('settings')->get('framework');
	    	    
	    if(in_array($plugin, $settings['activated'])){	    
	        if(Plugin::get($plugin) === false || Plugin::get($plugin)->deactivate() !== false){  
    	        arrayRemoveValue($settings['activated'], $plugin);
    	        arrayRemoveValue($settings['frontend']['preload'], $plugin);
    	        arrayRemoveValue($settings['backend']['preload'], $plugin);

                self::get('settings')->set('framework', $settings);

    	        // add menu for ZC 1.5.0 >
    	        if(function_exists('zen_deregister_admin_pages')){
        	        if(($menus = self::get('settings')->get($plugin . '.global.backend.menu', null)) != null){
                        foreach ($menus as $menu_key => $sub_menus)
        	                foreach($sub_menus as $menu){
        	                    $id = md5($menu['link']);
        	                    zen_deregister_admin_pages($id);
        	                }	                
        	        }
    	        }
	        }
	    }
	        	        	    
	    return true;
	}

    /**
     * checks if a plugin is activated
     *
     * @param $plugin
     * @return bool
     */
    public static function isActivated($plugin){
        return in_array($plugin, self::get('settings')->get('framework.activated'));
    }

    /**
     * Checks if we are in admin
     *
     * @static
     * @return bool
     */
	public static function isAdmin(){
	    return self::$is_admin;        
	}

    /**
     * gets the current enviornment
     *
     * @static
     * @return mixed
     */
    public static function getEnvironment(){
        return self::$environment;
    }
}