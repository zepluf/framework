<?php

namespace plugins\riCard;

use Symfony\Component\HttpFoundation\Request;

use plugins\riSimplex\Controller;
use plugins\riPlugin\Plugin;
use Symfony\Component\HttpFoundation\Response;

class AdminCardController extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function export(Request $request){
        global $db;

        if($request->get('action') == 'export'){

            if($request->get('pay_type', 0) > 0){
                $where[] = $db->bindVars(" pay_type = :pay_type ", ':pay_type', $request->get('pay_type'), 'integer');
                $type = 1;
                $where[] = $db->bindVars(" type = :type ", ':type', $type, 'integer');                                
            }
            elseif($request->get('type', 0) > 0){
                $type = $request->get('type');
                $where[] = $db->bindVars(" type = :type ", ':type', $type, 'integer');
            }
            
            if($request->get('export_type') == 'payment')
            list($select, $from, $where) = $this->_buildExportPaymentSelect($request, $type);
            else
            list($select, $from, $where) = $this->_buildExportOrderSelect($request, $type);
             
            if($request->get('card_orders_status', 0) > 0){
                $where[] = $db->bindVars(" card_orders_status = :card_orders_status ", ':card_orders_status', (int)$request->get('card_orders_status'), 'integer');
            }
            
             	                                    

            if($request->get('date_from', '') != ''){
                $date = new \DateTime($request->get('date_from'));
                $date_string = $date->format('Y-m-d').' 00:00:00';
                $where[] = $db->bindVars(" date_purchased >= :date_from ", ':date_from', $date_string, 'string');
            }

            if($request->get('date_to', '') != ''){
                $date = new \DateTime($request->get('date_to'));
                $date_string = $date->format('Y-m-d').' 23:59:59';
                $where[] = $db->bindVars(" date_purchased <= :date_to ", ':date_to', $date_string, 'string');
            }
            
            if($request->get('date_completed_from', '') != ''){
                $date = new \DateTime($request->get('date_completed_from'));
                $date_string = $date->format('Y-m-d').' 00:00:00';
                $where[] = $db->bindVars(" date_completed >= :date_from ", ':date_from', $date_string, 'string');
            }
    
            if($request->get('date_completed_to', '') != ''){
                $date = new \DateTime($request->get('date_completed_to'));
                $date_string = $date->format('Y-m-d');
                $where[] = $db->bindVars(" date_completed <= :date_to ", ':date_to', $date_string, 'string');
            }

            $sql = "SELECT " . $select . " FROM " . $from;

            if(!empty($where))
            $sql .= " WHERE " . implode(" AND ", $where);

            $sql .= " order by card_orders_id, date_purchased ";

            $result = $db->Execute($sql);
            	
            //echo $sql;var_dump($result->fields);die();
            	
            $data = Plugin::get('riUtility.Utility')->dbToArrayWithoutKey($result);

            if($request->get('export_type') == 'order')
            array_unshift($data, array_keys($result->fields));
            	
            $filedata = Plugin::get('riCsv.Csv')->export($data);
            	
            return new Response(
            $filedata,
            200,
            array(
	                 'Content-Type' => 'application/csv', 
	                 'Content-Disposition' => sprintf('attachment; filename="%s.csv"', 'temp') 
            )
            );
        }
        else {
            $this->_setCommonVars();
            $this->view->get('php::holder')->add('main', $this->view->render('riCard::_admin_sell_export'));
            return $this->render('riCard::admin_layout');
        }
    }

    public function cardSell(Request $request){
        	            
        $card_payment = Plugin::get('riCard.CardPayment');

        $result_list = Plugin::get('riResultList.ResultList');
        $result_list->setPagination(50);

        $result_list->setPageNumber($request->get('page', 1));
        	
        $card_orders = Plugin::get('riCard.CardOrders');

        $result_list->setResultSource($card_orders);
         
        // order
        $result_list->addSorter('date_purchased DESC');

        if(isset($_GET['customers_name']) && !empty($_GET['customers_name']))
        $result_list->addFilter('name like "%'.addslashes($_GET['customers_name']).'%"');

        if($request->get('date_from', '') != ''){
            $date = new \DateTime($request->get('date_from'));
            $date_string = $date->format('Y-m-d').' 00:00:00';
            $result_list->addFilter('date_purchased >= "'.$date_string.' 00:00:00"');
        }

        if($request->get('date_to', '') != ''){
            $date = new \DateTime($request->get('date_to'));
            $date_string = $date->format('Y-m-d');
            $result_list->addFilter('date_purchased <= "'.$date_string.' 23:59:59"');
        }

        if($request->get('date_completed_from', '') != ''){
            $date = new \DateTime($request->get('date_completed_from'));
            $date_string = $date->format('Y-m-d').' 00:00:00';
            $result_list->addFilter('date_completed >= "'.$date_string.' 00:00:00"');
        }

        if($request->get('date_completed_to', '') != ''){
            $date = new \DateTime($request->get('date_completed_to'));
            $date_string = $date->format('Y-m-d');
            $result_list->addFilter('date_completed <= "'.$date_string.' 23:59:59"');
        }
        
        if(isset($_GET['card_orders_status']) && !empty($_GET['card_orders_status']))
        $result_list->addFilter('card_orders_status = '.(int)$_GET['card_orders_status']);

        $pay_method = isset($_GET['pay_method']) ? $_GET['pay_method'] : 'sell';
        $this->view->setVars(array('pay_method' => $pay_method));
        switch($pay_method){
            case 'sell':
                $result_list->addFilter('type <> 2');
                break;
            case 'trade':
                $result_list->addFilter('type = 2');
                break;
        }
        if(isset($_GET['pay_type']) && !empty($_GET['pay_type']))
        $result_list->addFilter('pay_type = '.(int)$_GET['pay_type']);

        $action = isset($_GET['action']) ? $_GET['action'] : 'default';

        switch($_GET['action']){
            case 'delete':
                Plugin::get('riCard.CardOrders')->deleteById($_GET['card_orders_id']);
                $order = Plugin::get('riCard.CardOrders')->findById($_GET['card_orders_id']);
                $this->view->setVars(array('order' => $order));

                break;
        }

        $card_orders_id = 0;
        if(isset($_GET['card_orders_id']) && !empty($_GET['card_orders_id'])){
            $card_orders_id = $_GET['card_orders_id'];
            	
            if($_POST['sub_action'] == 'insert'){
                if(!empty($_POST['merchants_id']) && !empty($_POST['face_value']) && (float)$_POST['face_value'] > 0){
                    $order = Plugin::get('riCard.CardOrders')->findById($_GET['card_orders_id']);
                    if(($card = Plugin::get('riCard.Card')->create($_POST['merchants_id'], $_POST['face_value'])) != false){
                        $card->number = $_POST['number'];
                        $card->pin = $_POST['pin'];
                        $order->getCards()->add($card);
                        $order->save();
                    }
                    else{
                        Plugin::get('riLog.Logs')->copyToZen()->clear();
                        //zen_redirect(zen_href_link(FILENAME_SELL_YOUR_CARDS));
                    }
                }
            }
            	
            elseif($_POST['sub_action'] == 'update'){

                Plugin::load(array('riProduct'));
                $order = Plugin::get('riCard.CardOrders')->findById($_GET['card_orders_id']);
                $order->setInfoByArray($_POST['info']);
                	
                foreach($_POST['cards'] as $uid => $values){
                    
                    if($values['insert'] == 1){
                        if(($product = $order->getCards()->getByUId($uid)->createProduct($order->id)) !== false){
                            global $messageStack;
                            $messageStack->add(ri('New product generated: %products_id% ', array('%products_id%' => $product->productsId)), 'success');
                        }
                    }                    
                    if($values['delete'] == 1){
                        $product = $order->getCards()->deleteByUId($uid);
                    }
                    else{
                        foreach($values['info'] as $key => $value)
                        $order->getCards()->setByUId($uid, $key, $value);
                    }
                }
                //var_dump($order->getCards()->getAll());die();
                $order->save();
            }
            	
            if(($order = Plugin::get('riCard.CardOrders')->findById($_GET['card_orders_id'])) !== false){
                $cards = $order->getCards()->getAll();
                $total = $card_payment->calculateTotal($cards);
                Plugin::load(array('riCustomer'));
                $customer = Plugin::get('riCustomer.Customers')->findById($order->info['customers_id']);
                	
                $this->view->setVars(array(
					'order' => $order, 
					'total' => $total, 
					'cards' => $cards,
					'customer' => $customer
                ));
            }
        }
        	
        require(DIR_WS_CLASSES . 'currencies.php');
        $currencies = new \currencies();
        $this->view->setVars(array(
			'card_orders_id' => $card_orders_id,
			'currencies' => $currencies,
			'card_payment' => $card_payment,			
			'current_route' => $request->get('_route')
        ));

        $this->_setCommonVars();
        Plugin::get('riLog.Logs')->copyToZen(true);

        $this->view->get('php::holder')->add('main', $this->view->render('riCard::_admin_sell_main_slot', array('result_list' => $result_list)));

        return $this->render('riCard::admin_layout');
    }

    

    /**
     * 
     * Create new order
     * @param Request $request
     */
    public function order(Request $request){
        $this->_setCommonVars();
        
        $customer = self::_findCustomer($request);
        
        Plugin::load('riAddress');

        if($request->getMethod() == "POST"){
            $order = Plugin::get('riCard.CardOrder');
            $order->setInfoByArray($request->get('info'));
            
            //$cards_object = Plugin::get('riCard.Cards');	
            //$payment_object = Plugin::get('riCard.CardPayment');
            
            foreach($request->get('cards') as $card_info){
                if((float)$card_info['face_value'] > 0){
                    if(($card = Plugin::get('riCard.Card')->create($card_info['merchants_id'], $card_info['face_value'])) != false){
                        $card->number = $card_info['number'];
                        $card->pin = $card_info['pin'];
                        $card->buybackPercentage = $card_info['buyback_percentage'];
                        $order->getCards()->add($card);                    
                    }
                }
            }                
            
            $order->save();
            
            $this->view->setVars(array('order' => $order));
        }
        
        $this->view->get('php::holder')->add('main', $this->view->render('riCard::_admin_sell_order.php', array(
            'customer' => $customer,
        	'address' => Plugin::get('riAddress.Addresses')->findById($customer->customersDefaultAddressId),
            'number_of_card' => $request->get('number_of_card')
        )));
        
        return $this->render('riCard::admin_layout');
        //$this->render('riCard::admin_layout');
    }
    
    private function _buildExportPaymentSelect(Request $request, $type){
         
        $from = TABLE_CARD_ORDERS." o,
			    		".TABLE_ORDERS_STATUS." os";
         
        $where = array();
        	
        // to join tables
        $where[] = "os.orders_status_id = o.card_orders_status";

        $select = 'o.name, o.payment_email, o.amazon_value, o.card_orders_id, os.orders_status_name';

         
        switch($type){
            case 1:
                if($request->get('pay_type', 0) > 0){
                    switch($request->get('pay_type')){
                        case 1: // paypal
                            $select = 'o.payment_email, o.cash_value, "USD" as temp, o.card_orders_id, o.name, os.orders_status_name';
                            break;
                        case 2: // direct
                            $select = '22 as temp, o.routing_number, o.account_number, o.cash_value, o.card_orders_id, o.name, os.orders_status_name';
                            break;
                        case 3: // echeck
                            $select = 'o.name, o.street_address, o.suburb , o.city, o.state, o.postcode, o.cash_value, os.orders_status_name';
                            break;
                            	
                    }

                }
                break;
                 
            case 2: // amazon trade
                $select = 'o.name, o.payment_email, o.face_value, o.card_orders_id, os.orders_status_name';
                break;

            case 3: // amazon sell
                $select = 'o.name, o.payment_email, o.cash_value, o.card_orders_id, os.orders_status_name';
                break;
        }

        return array($select, $from, $where);
    }

    private function _buildExportOrderSelect(Request $request, $type){

        $where = array();

        // to join tables

        $where[] = "os.orders_status_id = o.card_orders_status";

         
        switch($request->get('export_order_type')){
            case 'detailed':
                $from = TABLE_CARD_ORDERS." o,
    			    		".TABLE_ORDERS_STATUS." os";
                 
                $select = 'o.date_purchased, o.name, o.type, os.orders_status_name, o.face_value, CASE pay_type WHEN 1 THEN o.paypal_value ELSE o.cash_value END AS payment_amount, o.surcharge, (o.cash_value + o.surcharge) as total_payment';
    
                switch($type){                    
                    case 2: // amazon trade
                        $select = 'o.date_purchased, o.name, o.type, os.orders_status_name, o.face_value, o.amazon_fee, o.surcharge, (o.amazon_fee + o.surcharge)  as total_transaction_fee';
                        break;                
                }
                
                break;
                
            case 'affiliate':
                $from = TABLE_CARD_ORDERS_CARDS. " oc ,".TABLE_CARD_ORDERS." o,
		    		".TABLE_ORDERS_STATUS." os";
                $where[] = "o.card_orders_id = oc.card_orders_id";
                $where[] = "o.affiliates_id IS NOT NULL";
                $select = 'o.card_orders_id, o.name, os.orders_status_name, o.date_completed, o.date_purchased, CASE pay_type WHEN 1 THEN o.paypal_value ELSE o.cash_value END AS payment_amount, o.affiliates_id';                

                break;
            default:
                $from = TABLE_CARD_ORDERS_CARDS. " oc ,".TABLE_CARD_ORDERS." o,
		    		".TABLE_ORDERS_STATUS." os";

                $where[] = "o.card_orders_id = oc.card_orders_id";
                 
                $select = 'o.date_purchased, o.card_orders_id, o.name, o.type, os.orders_status_name, oc.merchants_name, oc.face_value, oc.buyback_percentage, CASE pay_type WHEN 1 THEN o.paypal_value ELSE o.cash_value END AS payment_amount, oc.number, oc.pin';
                 
                switch($type){                    
                    case 2: // amazon trade
                        $select = 'o.date_purchased, o.card_orders_id, o.name, o.type, os.orders_status_name, oc.merchants_name, oc.face_value, oc.buyback_percentage, oc.amazon_fee, oc.number, oc.pin';
                        break;
                }
                break;
        }

        return array($select, $from, $where);
    }

    // just put this here for now, we may move it to a special helper later
    private function _setCommonVars(){

        $statuses = Plugin::get('riCard.CardOrders')->getStatuses();
        $payments = Plugin::get('riPlugin.Settings')->get('riCard.payments');

        $types_dropdown = $statuses_dropdown = $payments_dropdown = array(0 => array('id' => 0, 'text' => 'Please select'));

        foreach($payments[1]['payment_type'] as $id => $payment){
            $payments_dropdown[] = array('id' => $id, 'text' => $payment['name']);
        }

        foreach($payments as $id => $payment){
            $types_dropdown[] = array('id' => $id, 'text' => $payment['name']);
        }

        $statuses_dropdown = array(0 => array('id' => 0, 'text' => 'Please select'));

        foreach($statuses as $id => $name){
            $statuses_dropdown[] = array('id' => $id, 'text' => $name);
        }

        $this->view->setVars(array(
			'statuses' => $statuses,
			'payments' => $payments,
			'payments_dropdown' => $payments_dropdown, 
			'types_dropdown' => $types_dropdown, 
			'statuses_dropdown' => $statuses_dropdown
        ));
    }
    
    static function _findCustomer(Request $request){
        $customer = false;
        
        if($request->get('customers_id') > 0){
            $customer = Plugin::get('riCustomer.Customers')->findById($request->get('customers_id'));
        }
        
        else{           
        
            if($request->get('customers_email') != '' || $request->get('customers_email') != ''){
                $customer = Plugin::get('riCustomer.Customers')->findByEmailAddress($request->get('customers_email') , $request->get('customers_email'));
            }
            
            elseif($request->get('customers_firstname') != '' || $request->get('customers_lastname') != ''){
                $customer = Plugin::get('riCustomer.Customers')->findByName($request->get('customers_firstname') , $request->get('customers_lastname'));
            }
        }
        
        return $customer;
        
    }
}