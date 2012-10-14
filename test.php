<?php 
/**
 * a sample test file for simple tests
 */

// set up env to include application top
$store_path = realpath(__DIR__ . '/../');
ini_set('include_path', get_include_path() . PATH_SEPARATOR . $store_path . '/includes/');
chdir($store_path);
require('includes/application_top.php');
require('plugins/simpletest/autorun.php');

use plugins\riPlugin\Plugin;

/**
 * All tests class
 */
class AllTests extends TestSuite {

    /**
     * constructor for running all tests
     */
    function AllTests() {
        $this->TestSuite('All tests');
        foreach(Plugin::getLoaded() as $plugin){
        	foreach (glob('plugins/'.$plugin."/tests/*.php") as $file) { 
				$this->addFile($file);
			}
        }
    }
}