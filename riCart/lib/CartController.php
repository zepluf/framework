<?php

namespace plugins\riCart;

use plugins\riPlugin\Plugin;

use Symfony\Component\HttpFoundation\Request;
use plugins\riSimplex\Controller;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function add(Request $request){                
        $_SESSION['cart']->addCart($request->get('products_id'), $request->get('cart_quantity'));
                
        return new Response(json_encode(array(
        	'box_cart_content' => $this->view->render("riCart::_box_cart_content"), 
        	'current_product' => array(
                'id' => $request->get('products_id'),
                'quantity' => $_SESSION['cart']->get_quantity($request->get('products_id'))
            ) ,
        	'messages' => Plugin::get('riLog.Logs')->getAsArray())
            )
        );          
    }
}