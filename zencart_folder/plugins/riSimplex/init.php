<?php 

use plugins\riPlugin\Plugin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Reference;

Plugin::load(array('riSimplex'));

Plugin::getContainer()->register('context', 'Symfony\Component\Routing\RequestContext');
Plugin::getContainer()->register('matcher', 'Symfony\Component\Routing\Matcher\UrlMatcher')
    ->setArguments(array('%routes%', new Reference('context')));
    
Plugin::getContainer()->register('resolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');
 
Plugin::getContainer()->register('listener.router', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
    ->setArguments(array(new Reference('matcher')));
    
Plugin::getContainer()->register('listener.response', 'Symfony\Component\HttpKernel\EventListener\ResponseListener')
    ->setArguments(array('%charset%'));
    
Plugin::getContainer()->register('listener.exception', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
    ->setArguments(array('plugins\\riSimplex\\Controller::exceptionAction'));    

Plugin::getContainer()->getDefinition('dispatcher')->addMethodCall('addSubscriber', array(new Reference('listener.router')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.response')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.exception')));

Plugin::getContainer()->register('riSimplex.Framework', 'plugins\riSimplex\Framework')
    ->setArguments(array(new Reference('dispatcher'), new Reference('resolver')));

Plugin::getContainer()->setParameter('routes', $routes);
Plugin::getContainer()->setParameter('charset', 'UTF-8');    

$request = Request::createFromGlobals();

$response = Plugin::get('riSimplex.Framework')->handle($request);
 
