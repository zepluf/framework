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
namespace plugins\riZCAdmin\lib;

use plugins\riPlugin\Plugin;

/**
 * ZCAdmin class
 */
class ZCAdmin{

    /**
     * inject plugins' menu into Zencart menus
     *
     * @param $key
     * @param $menu
     */
    public function injectAdminMenu($key, &$menu){
        $links = Plugin::get('settings')->get('global.backend.menu.'.$key);
        if(is_array($links))
            foreach($links as $link){
                if(isset($link['route'])) {
                    $menu[] = array('text' => ri($link['text']), 'link' => riLink($link['route'], $link['parameters'], 'SSL', true));
                }
                else {
                    $menu[] = array('text' => ri($link['text']), 'link' => riLink($link['link']));
                }

            }
    }
}