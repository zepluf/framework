<?php
namespace plugins\riSimplex;

use plugins\riPlugin\Plugin;

use Symfony\Component\HttpFoundation\Response;

class Controller{
 	protected $response, $view;
	
	public function __construct(){
		$this->response = new Response();
		$this->view = Plugin::get('riCore.View');
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
}