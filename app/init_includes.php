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
// set locale
$container->get('translator')->setLocale($_SESSION['languages_code']);

// bof ri: ZePLUF
$container->get('event_dispatcher')->dispatch(Zepluf\Bundle\StoreBundle\Events::onPageStart, $core_event);
ob_start();
// eof ri: ZePLUF