<?php
/**
 * Created by RubikIntegration Team.
 * Date: 1/25/13
 * Time: 10:41 AM
 * Question? Come to our website at http://rubikintegration.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require('../zepluf_config.php');

require(APP_DIR . '/bootstrap.php');

// some hacks for zencart
ini_set('include_path', ZENCART_ADMIN_DIR . PATH_SEPARATOR . ini_get('include_path'));
chdir(ZENCART_ADMIN_DIR);

$PHP_SELF = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$fileName =  basename($PHP_SELF);

if("app.php" == $fileName) {
    $fileName = "index.php";
    $PHP_SELF = str_replace("app.php", "index.php", $PHP_SELF);
} elseif ("/manager/" == $PHP_SELF) {
    $fileName = "index.php";
    $PHP_SELF .= "index.php";
}

require(ZENCART_DIR . '/manager/' . $fileName);
