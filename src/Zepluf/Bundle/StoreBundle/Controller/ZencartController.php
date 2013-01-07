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

class ZencartController extends Controller
{
    public function staticAction(Request $request)
    {
        return new Response("zencartStaticPage");
    }
}
