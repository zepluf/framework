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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * main controller for managing plugins in backend
 */
class ShipmentController extends Controller
{
    public function estimatePostAction(Request $request)
    {
        $shipment = $this->get('storebundle.shipment');
    }

    public function abcAction(Request $request)
    {
        return $this->render('StoreBundle::a.html.php');
    }
}