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
use plugins\riPlugin\Plugin;

Plugin::load(array('riSimplex'));

$container->setParameter('request', $request);
try{
    $response = Plugin::get('riSimplex.Framework')->handle($request, Symfony\Component\HttpKernel\HttpKernelInterface::MASTER_REQUEST, false);
}catch (Exception $e){
    // do something?
    echo $e->getMessage();
    exit('something went wrong with the routing');
}