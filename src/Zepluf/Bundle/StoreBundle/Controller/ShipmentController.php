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
use Zepluf\Bundle\StoreBundle\Component\Shipment\ShippingRateRequest;

/**
 * main controller for managing plugins in backend
 */
class ShipmentController extends Controller
{
    public function getShipRatesAction(Request $request)
    {
        //  Parse Request
        $rateRequest = new ShippingRateRequest();


        $rateRequest
            ->setOriginationCountry('US')
            ->setOriginationPostal('90003')
            ->setDestinationCountry('VN')
            ->setDestinationPostal('213')
            ->setPackageWeight('10');

        $shipment = $this->get('storebundle.shipping_methods');
        $rates = $shipment->getRates($rateRequest);

        return $this->render('StoreBundle:Shipment:b.html.twig', array('rates' => $rates));
    }

    public function processAction(Request $request)
    {
        if ($request->isMethod('post')) {
            var_dump($request->request);
            die();
        }
    }

    public function formAction(Request $request)
    {
        $setting = new Setting();

        $form = $this->createFormBuilder($setting)
            ->add('name', 'text')
            ->add('value', 'text', array('required' => false))
            ->add('section', 'text')
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                die("TUan");
            }
        }

        return $this->render('StoreBundle::a.html.twig', array('form' => $form->createView()));
    }
}