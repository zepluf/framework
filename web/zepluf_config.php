<?php

/**
 * some basic configs
 */

/**
 * defines some paths here to support the different paths foz Zencart
 */

// path to the web dir, should not be edited
define("WEB_DIR", __DIR__);
// path to app dir, should not be edited
define("APP_DIR", __DIR__ . '/../app');

// The next 2 "defines" are for SQL cache support.
// For SQL_CACHE_METHOD, you can select from:  none, database, or file
// If you choose "file", then you need to set the DIR_FS_SQL_CACHE to a directory where your apache
// or webserver user has write privileges (chmod 666 or 777). We recommend using the "cache" folder inside the Zen Cart folder
// ie: /path/to/your/webspace/public_html/zen/cache   -- leave no trailing slash
define('SQL_CACHE_METHOD', 'none');
define('DIR_FS_SQL_CACHE', APP_DIR . '/cache');