<?php
namespace plugins\riCore;

use plugins\riPlugin\Plugin;
use Symfony\Component\DependencyInjection\Compiler\ResolveDefinitionTemplatesPass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use plugins\riSimplex\Controller;
use Symfony\Component\Yaml\Yaml;

class AdminController extends Controller{
    public function indexAction(){        
		$settings = Yaml::parse(__DIR__ .'/../../settings.yaml');
        
		// a temporary hack to avoid displaying installation folder
		$ignore = Plugin::get('settings')->get('framework.core', array());
		$ignore[] = 'install';

		$plugins = array();
        foreach(glob(DIR_FS_CATALOG . 'plugins/*', GLOB_ONLYDIR) as $plugin)
        {         
			$code_name = basename($plugin);
			// the core modules are not to be exposed
			if(!in_array($code_name, $ignore) && !in_array($code_name, $settings['installed'])){
				$plugins[] = array(
					'code_name' => $code_name,            	
				);             
			}
        }
   
        $this->container->get('templating.holder')->add('main', $this->view->render('riCore::_list', array('plugins' => $plugins)));

        return $this->render('riCore::admin_layout');       
    }
    
    public function infoAction(Request $request){
        $info = null;
        $plugin = $request->get('plugin');
        if(!empty($plugin)){
            $info = Plugin::info($plugin);                
        }
        return $this->render('riCore::admin_plugins_info', array('info' => $info));
    }
    
    public function activateAction(Request $request){
        $activated = false;
        $plugin = $request->get('plugin');
        if(!empty($plugin)){
            $info = Plugin::info($plugin);
            $activated = Plugin::activate($plugin);                            
        }

        if($activated){
            Plugin::get('settings')->saveLocal();
        }

        return new Response(json_encode(array(
        	'activated' => $activated,
            'messages' => Plugin::get('riLog.Logs')->getAsArray()
        )));        
    }
    
    public function deactivateAction(Request $request){
        $deactivated = false;
        $plugin = $request->get('plugin');
        if(!empty($plugin)){
            $info = Plugin::info($plugin);
            $deactivated = Plugin::deactivate($plugin);                            
        }

        if($deactivated){
            Plugin::get('settings')->saveLocal();
        }

        return new Response(json_encode(array(
            'activated' => !$deactivated,
            'messages' => Plugin::get('riLog.Logs')->getAsArray()
        )));
    }
    
    /**
     * 
     * Enter description here ...
     * @param Request $request
     */
    public function installAction(Request $request){
        $installed = false;
        $plugin = $request->get('plugin');
        if(!empty($plugin)){
            $installed = Plugin::install($plugin);
            Plugin::get('riLog.Logs')->copyFromZen();
        }

        if($installed){
            Plugin::get('settings')->saveLocal();
        }

        Plugin::get('riLog.Logs')->copyFromZen();

        return new Response(json_encode(array(
            'installed' => $installed,
            'messages' => Plugin::get('riLog.Logs')->getAsArray()
        )));
    }
    
    public function uninstallAction(Request $request){
        $uninstalled = false;
        $plugin = $request->get('plugin');
        if(!empty($plugin)){
            $uninstalled = Plugin::uninstall($plugin);
            Plugin::get('riLog.Logs')->copyFromZen();
        }

        if($uninstalled){
            Plugin::get('settings')->saveLocal();
        }

        return new Response(json_encode(array(
            'installed' => !$uninstalled,
            'messages' => Plugin::get('riLog.Logs')->getAsArray()
        )));
    }

    /**
     * Load current theme settings
     */
    public function loadThemeSettingsAction(){
        // we need to load theme settings
        Plugin::get('settings')->resetCache('theme');
        Plugin::get('settings')->load('theme', __DIR__ . '/../../../' . DIR_WS_TEMPLATE, 'theme.yaml');

        return new Response(json_encode(array(
            'messages' => array(array(
                'type' => 'success',
                'message' => ri('Theme %theme% settings have been loaded', array('%theme%' => DIR_WS_TEMPLATE))
            ))
        )));
    }
}