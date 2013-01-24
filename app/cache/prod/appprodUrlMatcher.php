<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appprodUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appprodUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);

        // riplugin_admin_plugins
        if (rtrim($pathinfo, '/') === '/riplugin/manager') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::indexAction',  '_route' => 'riplugin_admin_plugins',);
        }

        // riplugin_admin_plugins_info
        if (rtrim($pathinfo, '/') === '/riplugin/info') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_info');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsInfoAction',  '_route' => 'riplugin_admin_plugins_info',);
        }

        // riplugin_admin_plugins_install
        if (rtrim($pathinfo, '/') === '/riplugin/install') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_install');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsInstallAction',  '_route' => 'riplugin_admin_plugins_install',);
        }

        // riplugin_admin_plugins_uninstall
        if (rtrim($pathinfo, '/') === '/riplugin/uninstall') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_uninstall');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsUninstallAction',  '_route' => 'riplugin_admin_plugins_uninstall',);
        }

        // riplugin_admin_plugins_activate
        if (rtrim($pathinfo, '/') === '/riplugin/activate') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_activate');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsActivateAction',  '_route' => 'riplugin_admin_plugins_activate',);
        }

        // riplugin_admin_plugins_deactivate
        if (rtrim($pathinfo, '/') === '/riplugin/deactivate') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_deactivate');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsDeactivateAction',  '_route' => 'riplugin_admin_plugins_deactivate',);
        }

        // riplugin_admin_plugins_reset
        if (rtrim($pathinfo, '/') === '/riplugin/reset') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_reset');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsResetAction',  '_route' => 'riplugin_admin_plugins_reset',);
        }

        // riplugin_admin_plugins_load_theme_settings
        if (rtrim($pathinfo, '/') === '/riplugin/load_theme_settings') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_load_theme_settings');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::loadThemeSettingsAction',  '_route' => 'riplugin_admin_plugins_load_theme_settings',);
        }

        // riplugin_admin_plugins_configs_settings
        if (rtrim($pathinfo, '/') === '/riplugin/configs_settings') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_configs_settings');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsConfigAction',  '_route' => 'riplugin_admin_plugins_configs_settings',);
        }

        // riplugin_admin_plugins_show_settings
        if (rtrim($pathinfo, '/') === '/riplugin/show_settings') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_show_settings');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsShowSettingsAction',  '_route' => 'riplugin_admin_plugins_show_settings',);
        }

        // riplugin_admin_plugins_delete
        if (rtrim($pathinfo, '/') === '/riplugin/delete') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'riplugin_admin_plugins_delete');
            }

            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsDeleteAction',  '_route' => 'riplugin_admin_plugins_delete',);
        }

        // storebundle.contact_us
        if ($pathinfo === '/contact-us') {
            return array (  '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\ZencartController::staticAction',  'parameter_main_page' => 'contact_us',  '_route' => 'storebundle.contact_us',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
