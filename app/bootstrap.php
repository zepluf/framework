<?php
/**
 * intializes all the important variables that ZePLUF needs
 */

/**
 * includes the global functions that we need
 */

$environment = "prod";
$coreDir = __DIR__ . '/../';

require_once($coreDir . 'src/ZePluf/Bundle/StoreBundle/Functions/common.php');

/**
 * loads ZenMagick's loader
 */
require_once($coreDir . 'vendor/zenmagick/lib/base/classloader/ClassLoader.php');

// load the class loader and dependency injection component
$class_loader = new zenmagick\base\classloader\ClassLoader();

$class_loader->addNamespaces(array(
    'plugins' => __DIR__,
	'plugins\\riPlugin' => __DIR__ . '/plugins/riPlugin/lib@plugins\riPlugin',
    'plugins\\riCore' => __DIR__ . '/plugins/riCore/lib@plugins\riCore',
    'Symfony' => __DIR__ . '/../vendor/symfony/src',
    'Zepluf' => __DIR__ . '/../src',
    'Sensio\\Bundle\\FrameworkExtraBundle' => __DIR__ . '/../vendor/sensio/framework-extra-bundle/',
    'Monolog' => __DIR__ . '/../vendor/monolog/monolog/src/',
    'Doctrine\\Common' =>  __DIR__ . '/../vendor/doctrine/common/lib',
    'Doctrine\\ORM' => __DIR__ . '/../vendor/doctrine/orm/lib/',
    'Doctrine\\DBAL' => __DIR__ . '/../vendor/doctrine/dbal/lib/',
    'Doctrine\\Bundle\\DoctrineBundle' =>  __DIR__ . '/../vendor/doctrine/doctrine-bundle/',
));

$class_loader->register(true);

use Symfony\Component\HttpFoundation\Request;
use plugins\riPlugin\Plugin;

require_once 'AppKernel.php';
$kernel = new AppKernel($environment, false);
$kernel->loadClassCache();

$kernel->boot();

$container = $kernel->getContainer();
$container->get("plugin")->setLoader($class_loader);
$container->get("plugin")->init(__DIR__);
$container->get("plugin")->loadPlugins($container);

// some global vars to be used on Zencart as well
$request = Request::createFromGlobals();
$core_event = $container->get('StoreBundle.CoreEvent');
$riview = $container->get('view');