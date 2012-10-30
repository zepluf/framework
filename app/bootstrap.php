<?php
/**
 * intializes all the important variables that ZePLUF needs
 */

/**
 * includes the global functions that we need
 */
require_once('plugins/riPlugin/lib/common.php');

/**
 * loads ZenMagick's loader
 */
require_once(__DIR__ . '/../vendor/zenmagick/lib/base/classloader/ClassLoader.php');

// load the class loader and dependency injection component
$class_loader = new zenmagick\base\classloader\ClassLoader();

$class_loader->addNamespaces(array(
    'plugins' => __DIR__,
	'plugins\\riPlugin' => __DIR__ . '/plugins/riPlugin/lib@plugins\riPlugin',
    'plugins\\riCore' => __DIR__ . '/plugins/riCore/lib@plugins\riCore',
    'Symfony' => __DIR__ . '/../vendor/symfony/src',
    'Zepluf' => __DIR__ . '/../src',
    'Sensio\\Bundle\\FrameworkExtraBundle' => __DIR__ . '/../vendor/sensio/framework-extra-bundle/',
    'Doctrine\\Common' =>  __DIR__ . '/../vendor/doctrine/common/lib',
    'Doctrine\\ORM' => __DIR__ . '/../vendor/doctrine/orm/lib/',
    'Doctrine\\DBAL' => __DIR__ . '/../vendor/doctrine/dbal/lib/',
    'Doctrine\\Bundle\\DoctrineBundle' =>  __DIR__ . '/../vendor/doctrine/doctrine-bundle/',
));

$class_loader->register(true);

use Symfony\Component\HttpFoundation\Request;
use plugins\riPlugin\Plugin;

Plugin::setLoader($class_loader);
\plugins\riPlugin\Plugin::init();
require_once 'AppKernel.php';
$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
$kernel->boot();
$container = $kernel->getContainer();

\plugins\riPlugin\Plugin::loadPlugins($container);




//
//$doctrineExtension = new Doctrine\Bundle\DoctrineBundle\DependencyInjection\DoctrineExtension;
//$doctrineExtension->load(
//    array(array('dbal' => array(
//        'connections' => array('default' => array(
//            'user' => 'simple_shop',
//            'password' => 'simple_shop',
//            'dbname' => 'demo'
//        ))),
//                'orm' => array(
//                    'default_entity_manager' => 'default',
//                    'entity_managers' => array(
//                        'default' => array(
//                            'mappings' => array(
//                                //'YamlBundle' => array()
//                            )
//                        )
//                    )
//                )
//    )
//    ), $container);
//var_dump($container->get('database_connection'));die('hereee');

$request = Request::createFromGlobals();
