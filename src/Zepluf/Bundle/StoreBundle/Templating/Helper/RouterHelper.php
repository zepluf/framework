<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Vu Nguyen
 * Date: 12/9/12
 * Time: 1:41 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Zepluf\Bundle\StoreBundle\Templating\Helper;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper as FrameworkRouterHelper;

class RouterHelper extends FrameworkRouterHelper
{
    public function zenLink($route, $params = array(), $request_type = 'NONSSL', $is_admin = null, $file = 'index.php')
    {
        // TODO: hook in seo url?
        if ($is_admin === null) $is_admin = defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG;

        $host = ($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER;

        $link = $this->generator->generate($route, (array)$params);

        if ($is_admin && basename($_SERVER["SCRIPT_NAME"]) == 'ri.php') {
            return $host . $this->generator->getBaseUrl() . $link;
        }

        // catalog?
        if (!$is_admin && $file == 'index.php') {
            $link = explode('?', trim($link, '/'));
            if (IS_ADMIN_FLAG) {
                return zen_catalog_href_link($link[0], $link[1], $request_type);
            } else {
                return zen_href_link($link[0], $link[1], $request_type);
            }
        }

        if ($is_admin) {
            $file = 'ri.php';
            $host .= ($request_type == 'SSL') ? DIR_WS_HTTPS_ADMIN : DIR_WS_ADMIN;
        } else {
            $host .= ($request_type == 'SSL') ? DIR_WS_HTTPS_CATALOG : DIR_WS_CATALOG;
        }

        return $host . $file . $link;
    }
}