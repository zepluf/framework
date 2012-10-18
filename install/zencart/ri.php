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
 * always loads application_top first
 */
require('includes/application_top.php');
require('plugins/riSimplex/init.php');

$content = $response->getContent();
$response->setContent($content);
$response->send();