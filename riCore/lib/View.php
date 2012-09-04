<?php

namespace plugins\riCore;

use plugins\riPlugin\Plugin;
use Symfony\Component\Templating\DelegatingEngine;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

class View extends Object{
    private $vars = array(),
        $loader,
        $engine,
        $patterns = array();

    public function __construct(){

        $this->loader = Plugin::get('riCore.TemplateLoader');

        $this->patterns['default'] =  __DIR__.'/../../riSimplex/content/views/%name%';

        Plugin::getContainer()->setParameter('templating.loader', $this->loader);
        Plugin::getContainer()->setParameter('templating.nameparser', Plugin::get('templating.nameparser'));

        $this->engine = Plugin::get('riCore.TemplateEngine');
	    foreach(Plugin::get('settings')->get('framework.templating.engines', array()) as $engine_name){
	        if(($engine = Plugin::get('templating.engine.' . $engine_name)) !== false){
                $engine->addHelpers(array(Plugin::get('templating.helper.slot'), Plugin::get('templating.holder')));
                $this->engine->addEngine($engine);
            }
        }

        // always set router and reference to this
        $this->set(array(
            'router' => new Routing\Generator\UrlGenerator(Plugin::getContainer()->getParameter('routes'), Plugin::get('context')),
            'riview' => $this,
            'container' => Plugin::getContainer(),
            'holder' => Plugin::get('templating.holder')
        ));
    }

    public function getEngine(){
        return $this->engine;
    }

    public function render($view, $parameters = null){

        $parameters = is_array($parameters) ? array_merge($this->vars, $parameters) : $this->vars;

        $view = explode('::', $view);

        if(count($view) > 1)
            $view_path = $view[0] . '/content/views/' . $view[1];
        else
            $view_path = $view[0];

        // we will have to set path patterns to make sure we dont look for template files at extra places
        $patterns = $this->findPathPatterns($view);
        $this->loader->setPathPatterns($patterns);

        // default to php
        if(strpos($view_path, '.') === false) $view_path .= '.php';


        return $this->engine->render($view_path, $parameters);
    }

    public function findRenderPath($view){
        $view = explode('::', $view);
        if(count($view > 1))
            $view_path = $view[0] . '/content/views/' . $view[1];
        else
            $view_path = $view[0];

        $patterns = $this->findPathPatterns($view);

        foreach ($patterns as $scope => $path){
            if(file_exists($render_path = str_replace('%name%', $view_path, $path)))
                return $render_path;
        }
        return false;
    }

    public function addDefaultPathPattern($scope, $pattern){
        $this->patterns[$scope] = $pattern;
    }

    public function addPathPattern($scope, $pattern, &$patterns){
        $patterns[$scope] = $pattern;
    }

    private function findPathPatterns($view){
        $patterns = $this->patterns;
        if(!empty($view[1])){
            $this->addPathPattern('template', $this->patterns['template'] . 'plugins/%name%', $patterns);
            $this->addPathPattern($view[0], __DIR__ . '/../../%name%', $patterns);
        }
        else {
            // this is not a plugin template
            $this->addPathPattern('template', $this->patterns['template'] . '%name%', $patterns);
        }

        // default must always be the last one
        $last_key = end(array_keys($patterns));
        if($last_key != 'default' && isset($patterns['default'])) {
            $default = $patterns['default'];
            unset($patterns['default']);
            $patterns['default'] = $default;
        }
        return $patterns;
    }

    public function renderResponse($view, $parameters = null, Response $response = null){
        $response->setContent($this->render($view, $parameters));
        return $response;
    }

    public function set($vars){
        if(!is_array($vars)) $vars = array($vars);
        $this->vars = array_merge($this->vars, $vars);
        return $this;
    }

    public function get($name){
        return $this->vars[$name];
    }
}