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

/**
 * pluginEvents constants
 */
final class PluginEvents
{
    /**
     * The plugin.load.end event is thrown each time a plugin is loaded (1st time)
     * in the system.
     *
     * The event listener receives an plugins\riPlugin\PluginEvent
     * instance.
     *
     * @var string
     */
    const onPluginLoadEnd = 'plugin.load.end';
    const onInitEnd = 'init.end';
}