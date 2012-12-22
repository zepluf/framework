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

namespace Zepluf\Bundle\StoreBundle\Templating;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

/**
 * the view class
 */
class View
{

    /**
     * the view vars array
     *
     * @var array
     */
    private $vars = array();

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
     * @var
     */
    private $subEnv;

    /**
     * @var
     */
    private $rootDir;

    /**
     * @var
     */
    private $backendDir;

    /**
     * @var
     */
    private $templateDir;

    /**
     * @var
     */
    private $nameParser;

    /**
     * @var
     */
    private $loader;

    /**
     * inits the view with some variables
     */
    public function __construct($engine, $nameParser, $loader, $rootDir, $backendDir)
    {
        $this->engine = $engine;
        $this->nameParser = $nameParser;
        $this->loader = $loader;
        $this->rootDir = $rootDir;
        $this->backendDir = $backendDir;
    }

    /**
     * sets template dir
     *
     * @param $templateDir
     */
    public function setTemplateDir($templateDir)
    {
        $this->templateDir = $templateDir;
    }

    /**
     * sets the env
     *
     * @param $subEnv
     */
    public function setSubEnv($subEnv)
    {
        $this->subEnv = $subEnv;
    }

    /**
     * @param $loader
     * TODO: remove the use of constants
     */
    public function setPathPatterns($templateDir)
    {
        // we need to add some default paths into our view so that it knows where to look for template files
        if ($this->subEnv == "backend") {
            $path = $this->backendDir;
        } else {
            $path = $this->rootDir;
        }

        $this->loader->setPathPatterns(array(
            $path . '/includes/templates/' . $templateDir . '/plugins/%plugin%/Resources/views/%path%/%name%.%format%.%engine%',
            $path . '/includes/templates/template_default/plugins/%plugin%/Resources/views/%path%/%name%.%format%.%engine%',
            $this->rootDir . '/zepluf/app/plugins/%plugin%/Resources/views/%path%/%name%.%format%.%engine%',
            $path . '/includes/templates/' . $templateDir . '/%path%/%name%.%format%.%engine%',
            $path . '/includes/templates/template_default/%path%/%name%.%format%.%engine%'
        ));
    }

    /**
     * gets the render engine
     *
     * @return bool
     */
    public function getEngine()
    {
        return $this->engine;
    }

    public function getHelper($helper)
    {
        return $this->engine->get($helper);
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
     * render('pluginName:path/template_name.extension', $array_of_data_to_pass_into_template);
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
    public function render($view, $parameters = null)
    {

        $parameters = is_array($parameters) ? array_merge($this->vars, $parameters) : $this->vars;

        return $this->engine->render($view, $parameters);
    }

    /**
     * similar to render method, except that it returns the path instead of trying to render
     *
     * @param $view
     * @return bool|mixed
     */
    public function findRenderPath($view)
    {
        $template = $this->nameParser->parse($view);
        $file = $this->loader->load($template);
        return $file !== false ? (string)$file : false;
    }

    /**
     * populates the default pathPattern array, view will use this to look for template
     *
     * @param $scope
     * @param $pattern
     */
    public function addDefaultPathPattern($scope, $pattern)
    {
        $this->patterns[$scope] = $pattern;
    }

    /**
     * populates the pathPattern array, view will use this to look for template
     *
     * @param $scope
     * @param $pattern
     * @param $patterns
     */
    public function addPathPattern($scope, $pattern, &$patterns)
    {
        $patterns[$scope] = $pattern;
    }

    /**
     * renders and then returns a response object
     *
     * @param $view
     * @param null $parameters
     * @param null|\Symfony\Component\HttpFoundation\Response $response
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function renderResponse($view, $parameters = null, Response $response = null)
    {
        $response->setContent($this->render($view, $parameters));
        return $response;
    }

    /**
     * sets local variables to be available within the templates
     *
     * @param $vars
     * @return View
     */
    public function set($vars)
    {
        if (!is_array($vars)) $vars = array($vars);
        $this->vars = array_merge($this->vars, $vars);
        return $this;
    }

    /**
     * gets the local variables
     *
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->vars[$name];
    }
}