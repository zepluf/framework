<?php
/**
 * since Zencart autoloads all php files inside auto_loaders folder, we will use that
 * to includes our init file. Note that in this case the file is only loaded for paypal_ipn
 */

/**
 * init.php is where it the magic of ZePLUF begins
 */
require(__DIR__.'/../../plugins/init.php');