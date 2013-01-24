<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * appprodUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appprodUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    static private $declaredRoutes = array(
        'riplugin_admin_plugins' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::indexAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/manager/',    ),  ),),
        'riplugin_admin_plugins_info' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsInfoAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/info/',    ),  ),),
        'riplugin_admin_plugins_install' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsInstallAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/install/',    ),  ),),
        'riplugin_admin_plugins_uninstall' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsUninstallAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/uninstall/',    ),  ),),
        'riplugin_admin_plugins_activate' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsActivateAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/activate/',    ),  ),),
        'riplugin_admin_plugins_deactivate' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsDeactivateAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/deactivate/',    ),  ),),
        'riplugin_admin_plugins_reset' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsResetAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/reset/',    ),  ),),
        'riplugin_admin_plugins_load_theme_settings' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::loadThemeSettingsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/load_theme_settings/',    ),  ),),
        'riplugin_admin_plugins_configs_settings' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsConfigAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/configs_settings/',    ),  ),),
        'riplugin_admin_plugins_show_settings' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsShowSettingsAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/show_settings/',    ),  ),),
        'riplugin_admin_plugins_delete' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\AdminPluginController::pluginsDeleteAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/riplugin/delete/',    ),  ),),
        'storebundle.contact_us' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'Zepluf\\Bundle\\StoreBundle\\Controller\\ZencartController::staticAction',    'parameter_main_page' => 'contact_us',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/contact-us',    ),  ),),
    );

    /**
     * Constructor.
     */
    public function __construct(RequestContext $context, LoggerInterface $logger = null)
    {
        $this->context = $context;
        $this->logger = $logger;
    }

    public function generate($name, $parameters = array(), $absolute = false)
    {
        if (!isset(self::$declaredRoutes[$name])) {
            throw new RouteNotFoundException(sprintf('Route "%s" does not exist.', $name));
        }

        list($variables, $defaults, $requirements, $tokens) = self::$declaredRoutes[$name];

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute);
    }
}
