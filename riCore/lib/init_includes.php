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

// we need to add some default paths into our view so that it knows where to look for template files
if(IS_ADMIN_FLAG){
    $riview->addDefaultPathPattern('template', DIR_FS_ADMIN . 'includes/templates/template_default/');
}
else{
	$riview->addDefaultPathPattern('template', DIR_FS_CATALOG . DIR_WS_TEMPLATE);
}

// set locale
Plugin::get('translator')->setLocale($_SESSION['languages_code']);

// bof ri: ZePLUF
$core_event = plugins\riPlugin\Plugin::get('riCore.Event');
Plugin::get('dispatcher')->dispatch(plugins\riCore\Events::onPageStart, $core_event);
ob_start();
// eof ri: ZePLUF