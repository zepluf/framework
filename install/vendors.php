#!/usr/bin/env php
<?php

/*
 * loads all dependencies
 */

/**
 * baseDir will be the current folder
 */
$baseDir = dirname(dirname(__FILE__));
$vendorDeps = array(
    $baseDir => array(
        array('riCjLoader', 'git@github.com:yellow1912/cjloader.git', 'origin/ZePLUF', false),
		array('riCategory', 'git@github.com:yellow1912/riCategory.git', 'origin/master', false), 
		array('riCache', 'git@github.com:yellow1912/riCache.git', 'origin/HEAD', false),
		array('riUtility', 'git@github.com:yellow1912/riUtility.git', 'origin/HEAD', false),
        array('riLog', 'git@github.com:yellow1912/riLog.git', 'origin/HEAD', false),
        array('riResultList', 'git@github.com:ZePLUF/riResultList.git', 'origin/HEAD', false)
    ),
	$baseDir . '/riCore/vendor/zenmagick/lib/base' => array(
	    array('classloader', 'git@github.com:yellow1912/classloader.git', 'origin/HEAD', false)
	),
	$baseDir . '/riCore/vendor/symfony/src/Symfony/Component' => array(
		array('ClassLoader', 'git://github.com/symfony/ClassLoader.git', 'origin/HEAD', false),
		array('DependencyInjection', 'git://github.com/symfony/DependencyInjection.git', 'origin/HEAD', false),
		array('Config', 'git://github.com/symfony/Config.git', 'origin/HEAD', false),
		array('Yaml', 'git://github.com/symfony/Yaml.git', 'origin/HEAD', false),
		array('Routing', 'git://github.com/symfony/Routing.git', 'origin/HEAD', false),
		array('HttpFoundation', 'git://github.com/symfony/HttpFoundation.git', 'origin/HEAD', false),
		array('EventDispatcher', 'git://github.com/symfony/EventDispatcher.git', 'origin/HEAD', false),
		array('HttpKernel', 'git://github.com/symfony/HttpKernel.git', 'origin/HEAD', false),
		array('Validator', 'git://github.com/symfony/Validator.git', 'origin/HEAD', false),
		array('Translation', 'git://github.com/symfony/Translation.git', 'origin/HEAD', false),
		array('Templating', 'git://github.com/symfony/Templating.git', 'origin/HEAD', false),
		array('Finder', 'git://github.com/symfony/Finder.git', 'origin/HEAD', false)		
	),
	$baseDir . '/riCore/vendor/symfony/src/Symfony/Bundle' => array(
	    array('TwigBundle', 'git://github.com/symfony/TwigBundle.git', 'origin/HEAD', false)
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
