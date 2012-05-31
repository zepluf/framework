#!/usr/bin/env php
<?php

/*
 * This file is based on vendor.php of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$baseDir = dirname(dirname(__FILE__)).'/..';
$vendorDeps = array(
    $baseDir => array(
        array('riCjLoader', 'git@github.com:yellow1912/cjloader.git', 'origin/ZePLUF', false),
		array('riCategory', 'git@github.com:yellow1912/riCategory.git', 'origin/master', false), 
		array('riCache', 'git@github.com:yellow1912/riCache.git', 'origin/HEAD', false),
    )
);

if (isset($extraDeps)) $vendorDeps = array_merge($vendorDeps, (array)$extraDeps);
foreach ($vendorDeps as $vendorDir => $deps) {
    if (!is_dir($vendorDir)) {
        mkdir($vendorDir, 0777, true);
    }
    foreach ($deps as $dep) {
        list($name, $url, $rev, $recsub) = $dep;

        echo "> Installing/Updating $name\n";

        $installDir = $vendorDir.'/'.$name;
        if (is_dir($installDir) && !file_exists($installDir.'/.git')) {
            die(sprintf('%s exists but is not a valid repository', $installDir));
        }
        if (!is_dir($installDir)) {
            system(sprintf('git clone %s %s', escapeshellarg($url), escapeshellarg($installDir)));
        }

        system(sprintf('cd %s && git fetch origin && git reset --hard %s', escapeshellarg($installDir), escapeshellarg($rev)));

        if ($recsub) {
            system(sprintf('cd %s && git submodule update --init --recursive', escapeshellarg($installDir)));
        }
    }
}
