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

namespace Zepluf\Bundle\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * main controller for managing plugins in backend
 */
class AdminPluginController extends Controller
{

    /**
     * return the list of current plugins
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // a temporary hack to avoid displaying installation folder
        $ignore = array('install', 'simpletest');
        $plugins_names = $this->get("plugin")->getAvailablePlugins();
        foreach ($plugins_names as $plugin) {
            $code_name = basename($plugin);
            // the core modules are not to be exposed
            if (!in_array($code_name, $ignore)) {
                $plugins[] = array(
                    'code_name' => $code_name,
                );
            }
        }

        foreach ($plugins as $key => $plugin) {
            $plugins[$key]['installed'] = $this->get("plugin")->isInstalled($plugin['code_name']);
            $plugins[$key]['activated'] = $this->get("plugin")->isActivated($plugin['code_name']);
            $plugins[$key]['info'] = $this->get("plugin")->info($plugin['code_name']);
        }

        $this->get('templating.helper.holders')->add('main', $this->renderView('bundles:StoreBundle:backend/plugin/_list.html.php', array('plugins' => $plugins, 'core' => $this->get('settings')->get('framework.core', array()))));

        return $this->render('bundles:StoreBundle:backend/layout.html.php');
    }

    /**
     * load the plugin.xml file and returns the information of the plugin
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pluginsInfoAction(Request $request)
    {
        $info = null;
        $plugin = $request->get('plugin');
        if (!empty($plugin)) {
            $info = $this->get("plugin")->info($plugin);
        }
        return $this->render('bundles:StoreBundle:backend/plugin/_plugins_info.html.php', array('info' => $info));
    }

    /**
     * activates a plugin
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pluginsActivateAction(Request $request)
    {
        $activated = false;
        $plugin = $request->get('plugin');
        if (!empty($plugin)) {
            $info = $this->get("plugin")->info($plugin);
            $activated = $this->get("plugin")->activate($this->container, $plugin);
        }

        return $this->renderJson(array(
            'activated' => $activated,
            'messages' => $this->get('logs')->getLogs()
        ));
    }

    /**
     * deactivates a plugin
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pluginsDeactivateAction(Request $request)
    {
        $deactivated = false;
        $plugin = $request->get('plugin');
        if (!empty($plugin)) {
            $info = $this->get("plugin")->info($plugin);
            $deactivated = $this->get("plugin")->deactivate($this->container, $plugin);
        }

        return $this->renderJson(array(
            'activated' => !$deactivated,
            'messages' => $this->get('logs')->getLogs()
        ));
    }

    /**
     * config plugin
     * @param Request $request
     */
    public function pluginsConfigAction(Request $request)
    {
        $stt = false;
        $riname = $request->get('riname');
        $configs = $request->get('configs');

        if (!empty($configs) && !empty($riname)) {
            $this->get('settings')->saveLocal($riname, $configs);
            $stt = true;
        }

        return $this->renderJson(array(
            'status' => $stt,
            'messages' => $this->get('logs')->getLogs()
        ));
    }

    /**
     * shows the current settings of the plugin
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pluginsShowSettings(Request $request)
    {
        return $this->renderAjax(
            $this->view->render('plugins:' . $request->get('name') . ':backend/_settings.html.php', array(
                'riname' => $request->get('name'),
                'settings' => $this->get("settings")->get("plugins." . $request->get('name'))
            ))
        );
    }

    /**
     * deletes the plugin
     *
     * @param $path
     * @return bool
     */
    public function deleteAction($path)
    {
        if (is_dir($path))
            $dir_handle = opendir($path);
        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($path . "/" . $file)) {
                    chmod($path . "/" . $file, 0777);
                    unlink($path . "/" . $file);
                } else
                    $this->deleteAction($path . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($path);
    }

    /**
     * removes the plugin
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pluginsDeleteAction(Request $request)
    {
        $stt = false;
        $riname = $request->get('name');
        $path = realpath(__DIR__ . '/../../' . $riname);

        $this->deleteAction($path);

        if (!file_exists($path))
            $stt = true;

        return $this->renderJson(array(
                'status' => $stt
            )
        );
    }

    /**
     * installs a plugin
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pluginsInstallAction(Request $request)
    {
        $installed = false;
        $plugin = $request->get('plugin');
        if (!empty($plugin)) {
            $installed = $this->get("plugin")->install($this->container, $plugin);
            $this->get('logs')->copyFromZen();
        }

        $this->get('logs')->copyFromZen();

        return $this->renderJson(array(
            'installed' => $installed,
            'messages' => $this->get('logs')->getLogs()
        ));
    }

    /**
     * uninstalls a plugin
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pluginsUninstallAction(Request $request)
    {
        $uninstalled = false;
        $plugin = $request->get('plugin');
        if (!empty($plugin)) {
            $uninstalled = $this->get("plugin")->uninstall($this->container, $plugin);
            $this->get('logs')->copyFromZen("backend");
        }

        return $this->renderJson(array(
            'installed' => !$uninstalled,
            'messages' => $this->get('logs')->getLogs()
        ));
    }

    /**
     * reload a plugin's settings
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function pluginsResetAction(Request $request)
    {
        $this->get('settings')->resetCache($request->get('plugin'));
        $this->get('settings')->load($request->get('plugin'));

        $this->get('logs')->notify('settings reloaded');        

        return $this->renderJson(array(
                'messages' => $this->get('logs')->getLogs())
        );
    }

    /**
     * Load current theme settings
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadThemeSettingsAction()
    {
        // we need to load theme settings
        $this->get('settings')->resetCache('theme');
        // TODO: remove the constants
        $this->get('settings')->loadTheme('frontend', $this->container->getParameter("store.frontend.templates_dir") . '/' . $this->container->getParameter("store.frontend.current_template"));

        return $this->renderJson(array(
            'messages' => array(array(
                'type' => 'success',
                'message' => $this->get("translator")->trans('Theme %theme% settings have been loaded', array('%theme%' => DIR_WS_TEMPLATE))
            ))
        ));
    }
}