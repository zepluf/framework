<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 11/24/12
 * Time: 3:30 AM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class PluginRouteLoader extends Loader
{
    protected $sysSettings;

    protected $settings;

    public function __construct($sysSettings, $settings)
    {
        $this->settings = $settings;
        $this->sysSettings = $sysSettings;
    }

    public function supports($resource, $type = null)
    {
        return 'plugin_resource_type' === $type;
    }

    public function load($resource, $type = null)
    {
        $pluginsSettings = $this->settings->get('plugins');

        $collection = new RouteCollection();

        if(isset($this->sysSettings['activated']) && is_array($this->sysSettings['activated'])) {

            foreach ($this->sysSettings['activated'] as $plugin) {
                $plugin_lc_name = strtolower($plugin);
                if (isset($pluginsSettings[$plugin_lc_name]['routes'])) {
                    foreach ($pluginsSettings[$plugin_lc_name]['routes'] as $key => $route) {
                        $route = array_merge(array('pattern' => '',
                            'defaults' => array(),
                            'requirements' => array(),
                            'options' => array()), $route);
                        if (strpos($route['pattern'], '/') !== false) {
                            $route['pattern'] = $plugin_lc_name . $route['pattern'];
                        } else {
                            $route['pattern'] = $plugin_lc_name . '_' . $route['pattern'];
                        }

                        $collection->add($plugin_lc_name . '_' . $key, new Route($route['pattern'], $route['defaults'], $route['requirements'], $route['options']));
                    }
                }
            }
        }

        return $collection;
    }
}