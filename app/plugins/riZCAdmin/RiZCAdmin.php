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

namespace plugins\riZCAdmin;

use plugins\riCore\PluginCore;

/**
 * the main class of riZCAdmin
 */
class RiZCAdmin extends PluginCore{

    /**
     * inits plugin
     *
     * @inherit
     */
    public function init(){

        if(IS_ADMIN_FLAG){
            global $autoLoadConfig;
            $autoLoadConfig[200][] = array('autoType' => 'require', 'loadFile' => __DIR__ . '/lib/init_includes.php');
        }

    }
}