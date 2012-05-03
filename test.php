<?php 
// set up env to include application top
$store_path = realpath(__DIR__ . '/../');
ini_set('include_path', get_include_path() . PATH_SEPARATOR . $store_path . '/includes/');
chdir($store_path);
require('includes/application_top.php');
require('plugins/simpletest/autorun.php');

use plugins\riPlugin\Plugin;

class AllTests extends TestSuite {
    function AllTests() {
        $this->TestSuite('All tests');
        foreach(Plugin::getLoaded() as $plugin){
        	foreach (glob('plugins/'.$plugin."/tests/*.php") as $file) { 
				$this->addFile($file);
			}
        }
    }
}