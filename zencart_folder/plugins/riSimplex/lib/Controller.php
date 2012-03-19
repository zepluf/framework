<?php
namespace plugins\riSimplex;

use plugins\riPlugin\Plugin;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Controller extends ContainerAware{
 	protected $response, $view, $router;
	
	public function __construct(){
		$this->response = new Response();
		$this->view = Plugin::get('riCore.View');
		$this->router = $this->view->getVar('router');
		$this->setContainer(Plugin::getContainer());
	}
	
	public function exceptionAction(){
		//
	}
	
 	/**
     * Renders a view.
     *
     * @param string   $view The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
    	if($response == null) $response = $this->response;
        return $this->view->renderResponse($view, $parameters, $response);
    }
    
	/**
     * Generates a URL from the given parameters.
     *
     * @param string  $route      The name of the route
     * @param mixed   $parameters An array of parameters
     * @param Boolean $absolute   Whether to generate an absolute URL
     *
     * @return string The generated URL
     */
    public function generateUrl($route, $parameters = array(), $absolute = false)
    {
        return $this->router->generate($route, $parameters, $absolute);
    }
    
	/**
     * Returns a RedirectResponse to the given URL.
     *
     * @param string  $url The URL to redirect to
     * @param integer $status The status code to use for the Response
     *
     * @return RedirectResponse
     */
    public function redirect($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }
}