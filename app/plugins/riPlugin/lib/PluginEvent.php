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

use Symfony\Component\EventDispatcher\Event;

/**
 * plugin event class
 */
class PluginEvent extends Event
{
    /**
     * plugin's settings
     *
     * @var
     */
    private $settings;

    /**
     * plugin's name
     *
     * @var
     */
    private $plugin;

    /**
     * sets the plugin
     *
     * @param $plugin
     * @return PluginEvent
     */
	public function setPlugin($plugin){
        $this->plugin = $plugin;
        return $this;
    }   

    /**
     * gets the plugin
     *
     * @return mixed
     */
    public function getPlugin(){
    	return $this->plugin;
    }

    /**
     * set settings
     *
     * @param $settings
     * @return PluginEvent
     */
    public function setSettings($settings){
        $this->settings = $settings;
        return $this;
    }   

    /**
     * gets settings
     *
     * @return mixed
     */
    public function getSettings(){
    	return $this->settings;
    }
}