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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

/**
 * the view class
 */
class View implements \ArrayAccess
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
     * @var
     */
    private $phpEngine;

    /**
     * path patterns
     *
     * @var array
     */
    private $patterns = array();

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
    public function __construct($engine, $phpEngine, $nameParser, $loader)
    {
        $this->engine = $engine;
        $this->phpEngine = $phpEngine;
        $this->nameParser = $nameParser;
        $this->loader = $loader;
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

        $content = $this->engine->render($view, $parameters);

        if($content !== false) {
            return "\r\n <!-- bof: $view --> \r\n" . $content . "\r\n <!-- eof: $view --> \r\n";
        }
        else {
            return "";
        }
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

    /**
     * Gets a helper value.
     *
     * @param string $name The helper name
     *
     * @return mixed The helper value
     *
     * @throws \InvalidArgumentException if the helper is not defined
     *
     * @api
     */
    public function offsetGet($name)
    {
        return $this->phpEngine->get($name);
    }

    /**
     * Returns true if the helper is defined.
     *
     * @param string $name The helper name
     *
     * @return Boolean true if the helper is defined, false otherwise
     *
     * @api
     */
    public function offsetExists($name)
    {
        return $this->phpEngine->has($name);
    }

    /**
     * Sets a helper.
     *
     * @param HelperInterface $name  The helper instance
     * @param string          $value An alias
     *
     * @api
     */
    public function offsetSet($name, $value)
    {
        $this->phpEngine->set($name, $value);
    }

    /**
     * Removes a helper.
     *
     * @param string $name The helper name
     *
     * @api
     */
    public function offsetUnset($name)
    {
        throw new \LogicException(sprintf('You can\'t unset a helper (%s).', $name));
    }
}