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

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

/**
 * the core controller class. All controller classes should extend this class
 */
class Controller extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * runs before any controller action
     *
     * @param \Symfony\Component\EventDispatcher\Event $event
     */
    public function beforeAction(Event $event)
    {
        $is_permitted = true;
        if ($event->getRequest()->get('role', '') == 'isAdmin') {
            if (!defined('IS_ADMIN_FLAG') || !IS_ADMIN_FLAG)
                $is_permitted = false;
        } else {
            $route_parts = explode('_', $event->getRequest()->get('_route'));
            if ($route_parts[1] == 'admin' && !IS_ADMIN_FLAG) {
                $is_permitted = false;
            }
        }
        if (!$is_permitted)
            die(ri('You do not have permission to access an admin route from here!'));
    }

    /**
     * renders the response as json then exits right away
     *
     * @param $data
     * @param null|\Symfony\Component\HttpFoundation\Response $response
     */
    public function renderJson($data, Response $response = null)
    {
        session_write_close();
        if ($response == null) $response = new Response();
        $response->setContent(json_encode($data));
        $response->send();
        exit();
    }

    /**
     * renders the response as ajax then exits right away
     *
     * @param $data
     * @param null|\Symfony\Component\HttpFoundation\Response $response
     */
    public function renderAjax($data, Response $response = null)
    {
        session_write_close();
        if ($response == null) $response = new Response();
        $response->setContent($data);
        $response->send();
        exit();
    }
}