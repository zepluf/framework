<?php
/**
 * Created by RubikIntegration Team.
 * Date: 1/6/13
 * Time: 11:13 AM
 * Question? Come to our website at http://rubikintegration.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Zepluf\Bundle\StoreBundle\ZencartResponse;

class ZencartController extends Controller
{
    public function staticAction(Request $request)
    {
        $this->convertParameters($request);
        return new ZencartResponse(ZencartResponse::CONTENT_STATIC_PAGE);
    }

    public function pageNotFoundAction(Request $request)
    {
        $this->convertParameters($request);
        return new ZencartResponse('', 404);
    }

    private function convertParameters($request)
    {
        $parameters = $request->attributes->all();
        // if this is a zencart page, we do need to set the params
        if (isset($parameters["parameter_main_page"])) {
            foreach ($parameters as $key => $value) {
                if (strpos($key, "parameter_") !== false) {
                    $_key = substr($key, 10);
                    $_GET[$_key] = $_REQUEST[$_key] = $value;
                }
            }
        }
    }
}