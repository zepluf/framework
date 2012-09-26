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
		//$ignore = Plugin::get('settings')->get('framework.core', array());
		$ignore = array('install', 'simpletest');

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
   
        $this->container->get('templating.holder')->add('main', $this->view->render('riCore::_list', array('plugins' => $plugins, 'core' => Plugin::get('settings')->get('framework.core', array()))));

        return $this->render('riZCAdmin::backend/layout');
    }
    
    public function pluginsInfoAction(Request $request){
        $info = null;
        $plugin = $request->get('plugin');
        if(!empty($plugin)){
            $info = Plugin::info($plugin);                
        }
        return $this->render('riCore::_plugins_info', array('info' => $info));
    }
    
    public function pluginsActivateAction(Request $request){
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
    
    public function pluginsDeactivateAction(Request $request){
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
     * config plugin
     * @param Request $request
     */
    public function pluginsConfigAction(Request $request){
        $stt = false;
        $configs = array();
        $riname = $request->get('riname');
        $configs = $request->get('configs');

        if(!empty($configs) && !empty($riname)){
            Plugin::get('settings')->saveLocal($riname, $configs);
            $stt = true;
        }

        return new Response(json_encode(array(
            'status' => $stt,
            'messages' => Plugin::get('riLog.Logs')->getAsArray()
        )));
    }

    public function pluginsShowSettings(Request $request){
        $riname = $request->get('name');
        $config_path = realpath(__DIR__.'/../../'.$riname.'/content/views') . '/';
        if(file_exists($config_path . '_settings.php'))
            $view = $this->view->render($riname . '::_settings.php', array('riname' => $riname));

        return new Response(json_encode(array(
            'view' => isset($view) ? $view : false
            )
        ));
    }

    public function deleteAction($path){
        if (is_dir($path))
            $dir_handle = opendir($path);
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($path."/".$file)){
                    chmod($path."/".$file, 0777);
                    unlink($path."/".$file);
                }else
                    $this->deleteAction($path.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($path);
    }

    public function pluginsDeleteAction(Request $request){
        $stt = false;
        $riname = $request->get('name');
        $path = realpath(__DIR__.'/../../'.$riname);
        //var_dump($path);
        $this->deleteAction($path);

        if(!file_exists($path))
            $stt = true;

        return new Response(json_encode(array(
                'status' => $stt
            )
        ));
    }

    /**
     * 
     * Enter description here ...
     * @param Request $request
     */
    public function pluginsInstallAction(Request $request){
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
    
    public function pluginsUninstallAction(Request $request){
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

    public function pluginsResetAction(Request $request){
        Plugin::get('settings')->resetCache($request->get('plugin'));
        Plugin::get('settings')->load($request->get('plugin'));

        Plugin::get('riLog.Logs')->add(array(
            'type' => 'success',
            'message' => 'settings reloaded'
        ));

        return $this->renderJson(array(
            'messages' => Plugin::get('riLog.Logs')->getAsArray())
        );
    }

    /**
     * Load current theme settings
     */
    public function loadThemeSettingsAction(){
        // we need to load theme settings
        Plugin::get('settings')->resetCache('theme');
        Plugin::get('settings')->loadTheme('frontend', __DIR__ . '/../../../' . DIR_WS_TEMPLATE);

        return new Response(json_encode(array(
            'messages' => array(array(
                'type' => 'success',
                'message' => ri('Theme %theme% settings have been loaded', array('%theme%' => DIR_WS_TEMPLATE))
            ))
        )));
    }
}