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

/**
 * always load application_top first
 */
require('includes/application_top.php');

// added to allow setting up core plugins AFTER all zencart variables have been setup
if($_GET['setup'] == 1){
    plugins\riPlugin\Plugin::setup((bool)$_GET['force']);
    die(sprintf("Setup has been done! You can <a href='%s'>click here</a> to visit the ZePLUF Manager", "ri.php/ricore/manager/"));
}

require('../plugins/riSimplex/init.php');

//some hacks for zencart
ob_start();
require(DIR_WS_INCLUDES . 'header.php');
$header = ob_get_clean();

ob_start();
require(DIR_WS_INCLUDES . 'footer.php');
$footer = ob_get_clean();

$content = $response->getContent();
$content = str_replace(array("</head>", "</body>"), array($header . '</head>', $footer . '</body>'), $content);

echo $content;

$print_content = false;
require('includes/application_bottom.php');

$response->setContent($content);
$response->send();
