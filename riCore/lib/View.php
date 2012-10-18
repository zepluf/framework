<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace plugins\riCore;

use Symfony\Component\Templating\DelegatingEngine;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

/**
 * the view class
 */
class View extends Object
{

    /**
     * the container
     *
     * @var \plugins\riPlugin\Container
     */
    private $container;

    /**
     * the view vars array
     *
     * @var array
     */
    private $vars = array();

    /**
     * cjloader
     *
     * @var bool
     */
    private $loader;

    /**
     * template engine
     *
     * @var bool
     */
    private $engine;

    /**
     * path patterns
     *
     * @var array
     */
    private $patterns = array();

    /**
     * inits the view with some variables
     */
    public function __construct(\plugins\riPlugin\Container $container){

        $this->container = $container;

        $this->loader = $this->container->get('riCore.TemplateLoader');

        //$this->patterns['default'] =  __DIR__.'/../../riSimplex/content/views/%name%';

        $this->container->setParameter('templating.loader', $this->loader);
        $this->container->setParameter('templating.nameparser', $this->container->get('templating.nameparser'));

        $this->engine = $this->container->get('riCore.TemplateEngine');
	    foreach($this->container->get('settings')->get('framework.templating.engines', array()) as $engine_name){
	        if(($engine = $this->container->get('templating.engine.' . $engine_name)) !== false){
                $engine->addHelpers(array($this->container->get('templating.helper.slot'), $this->container->get('templating.holder')));
                $this->engine->addEngine($engine);
            }
        }

        // always set router and reference to this
        $this->set(array(
            'router' => new UrlGenerator($this->container->getParameter('routes'), $this->container->get('context')),
            'riview' => $this,
            'container' => $this->container,
            'holder' => $this->container->get('templating.holder')
        ));
    }

    /**
     * gets the render engine
     *
     * @return bool
     */
    public function getEngine(){
        return $this->engine;
    }

    /**
     * renders a specific template
     *
     * <code>
     * render('template_name.extension', $array_of_data_to_pass_into_template);
     * </code>
     *
     * to render a plugin's template
     *
     * <code>
     * render('pluginName::path/template_name.extension', $array_of_data_to_pass_into_template);
     * </code>
     *
     * Note: $array_of_data_to_pass_into_template should be like this: array('key1' => 'value1', 'key2' => 'value2')
     * Inside the template file, you can do echo $key which will give you 'value1'
     *
     * Note:
     * * Frontend:
     * * * Core: View will look in 1. includes/templates/template_default/ then 2. includes/templates/current_template/
     * * * Plugin: View will look in 1. includes/templates/current_template/plugins/pluginName/content/ then 2. plugins/pluginName/content/
     * * Backend:
     * * * Core: View will look in 1. admin_folder/includes/templates/template_default/
     * * * Plugin: same with frontend
     *
     * @param $view
     * @param null $parameters
     * @return mixed
     */
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

    /**
     * similar to render method, except that it returns the path instead of trying to render
     *
     * @param $view
     * @return bool|mixed
     */
    public function findRenderPath($view){
        $view = explode('::', $view);
        if(count($view) > 1)
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

    /**
     * populates the default pathPattern array, view will use this to look for template
     *
     * @param $scope
     * @param $pattern
     */
    public function addDefaultPathPattern($scope, $pattern){
        $this->patterns[$scope] = $pattern;
    }

    /**
     * populates the pathPattern array, view will use this to look for template
     *
     * @param $scope
     * @param $pattern
     * @param $patterns
     */
    public function addPathPattern($scope, $pattern, &$patterns){
        $patterns[$scope] = $pattern;
    }

    /**
     * used by render and findRenderPath to find the template location
     *
     * @param $view
     * @return array
     */
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
//        $last_key = end(array_keys($patterns));
//        if($last_key != 'default' && isset($patterns['default'])) {
//            $default = $patterns['default'];
//            unset($patterns['default']);
//            $patterns['default'] = $default;
//        }

        return $patterns;
    }

    /**
     * renders and then returns a response object
     *
     * @param $view
     * @param null $parameters
     * @param null|\Symfony\Component\HttpFoundation\Response $response
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function renderResponse($view, $parameters = null, Response $response = null){
        $response->setContent($this->render($view, $parameters));
        return $response;
    }

    /**
     * sets local variables to be available within the templates
     *
     * @param $vars
     * @return View
     */
    public function set($vars){
        if(!is_array($vars)) $vars = array($vars);
        $this->vars = array_merge($this->vars, $vars);
        return $this;
    }

    /**
     * gets the local variables
     *
     * @param $name
     * @return mixed
     */
    public function get($name){
        return $this->vars[$name];
    }
}