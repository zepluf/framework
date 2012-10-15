<?php 
/**
 * a sample test file for simple tests
 */

// set up env to include application top
$site_path = realpath(__DIR__ . '/../') . '/';
ini_set('include_path', $site_path . PATH_SEPARATOR . $site_path . 'plugins/' . PATH_SEPARATOR . ini_get('include_path'));
chdir($site_path);

$loaderPrefix = 'test';
define('STRICT_ERROR_REPORTING', true);
require($site_path . 'includes/application_top.php');
require('plugins/riCore/vendor/simpletest/autorun.php');

use plugins\riPlugin\Plugin;

/**
 * All tests class
 */
class AllTests extends TestSuite {

    /**
     * constructor for running all tests
     */
    function __construct() {
        parent::__construct();
        foreach(Plugin::getLoaded() as $plugin){
        	foreach (glob(__DIR__ . '/' . $plugin . "/tests/*.php") as $file) {
				$this->addFile($file);
			}
        }
    }
}