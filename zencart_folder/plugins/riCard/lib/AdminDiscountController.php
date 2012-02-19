<?php 

namespace plugins\riCard;

use Symfony\Component\HttpFoundation\Request;

use plugins\riSimplex\Controller;
use plugins\riPlugin\Plugin;
use Symfony\Component\HttpFoundation\Response;

class AdminDiscountController extends Controller{
    
    public function export(Request $request){
        global $db;

        $sql = "SELECT d.card_discounts_id, d.customers_id, CONCAT(c.customers_firstname, ' ', c.customers_lastname), d.merchants_id, m.name, d.discount_percentage
        	FROM " . TABLE_CARD_DISCOUNTS . " d," . TABLE_CARD_MERCHANTS . " m," . TABLE_CUSTOMERS . " c
        	WHERE m.id = d.merchants_id
        	AND c.customers_id = d.customers_id
        	ORDER BY d.customers_id";
        $result = $db->Execute($sql);
            	        
        $data = Plugin::get('riUtility.Utility')->dbToArrayWithoutKey($result);            	
            	
        $filedata = Plugin::get('riCsv.Csv')->export($data);
            	
        return new Response(
        $filedata,
        200,
        array(
                 'Content-Type' => 'application/csv', 
                 'Content-Disposition' => sprintf('attachment; filename="%s.csv"', 'discounts') 
        ));        
    }
    
    public function import(Request $request){
	    if($request->getMethod() == "POST"){
	        $data = Plugin::get('riCsv.Csv')->import($request->files->get('file'));
	        foreach ($data as $row){
	            $merchant = Plugin::get('riCard.CardDiscount')->setArray(array(
	                'card_discounts_id' => (int)$row[0],
	            	'customers_id' => (int)$row[1],
	            	'merchants_id' => (int)$row[3],
	                'discount_percentage' => (float)$row[5]
	            ))->save();
	        }

	        $this->view->get('php::holder')->add('main', ri('proccesed %count% rows', array('%count%' => count($data))));
	    }
	    $this->view->get('php::holder')->add('main', $this->view->render('riCard::_import_discount'));
	    
	    return $this->render('riMerchant::admin_layout');
	}
	
    public function index(Request $request){   
        global $db;
        
        Plugin::load('riCustomer');
                
        $card_discounts_id = $request->get('card_discounts_id', 0);

        $customer = AdminCardController::_findCustomer($request);        
        
        if($customer !== false){         

            // update discount
            if($request->getMethod() == "POST"){
                foreach($request->get('merchant') as $merchants_id => $merchant){
                    if((int)$merchant['card_discounts_id'] >= 0){
                        $discount = Plugin::get('riCard.CardDiscounts')->findById($merchant['card_discounts_id']);
                        if((float)$merchant['discount_percentage'] == 0)
                            $discount->delete();
                        else{
                            $discount->discountPercentage = (float)$merchant['discount_percentage'];
                            $discount->save();
                        }
                    }
                    elseif((float)$merchant['discount_percentage'] > 0){
                        $discount = Plugin::get('riCard.CardDiscount')->setArray(array(
            	            'card_discounts_id' => 0,
            	            'customers_id' => $customer->customersId,
            	        	'merchants_id' => $merchants_id,
            	            'discount_percentage' => (float)$merchant['discount_percentage'],
                        ))->save();
                    }
                }
            }
            
            $result_list = Plugin::get('riCore.Collection');
            $result_list->addFilter('(customers_id = '.$customer->customersId. ' OR customers_id IS NULL)');
            if($request->get('merchants_id') > 0){
                $result_list->addFilter('id = '.(int)$request->get('merchants_id'));
            }
            $result_list->setPageNumber($request->get('page', 1));
            $result_list->setPagination(50);
            $result_source = Plugin::get('riResultList.ResultSource');
            $model = Plugin::get('riCore.Model');
            $model->init(TABLE_CARD_MERCHANTS, 'id');            
            $result_source->select("name, card_discounts_id, id, buyback_percentage, discount_percentage")->from(TABLE_CARD_MERCHANTS." zm left join ".TABLE_CARD_DISCOUNTS." cd on zm.id = cd.merchants_id")
            ->setModel($model);                                    
            $result_list->setResultSource($result_source);              
            
            // we also need to get the default discount
            $sql = "SELECT card_discounts_id, id, buyback_percentage, discount_percentage FROM ".
                TABLE_CARD_DISCOUNTS." cd left join " . TABLE_CARD_MERCHANTS." zm on zm.id = cd.merchants_id
                WHERE customers_id = :customers_id AND merchants_id = 0";
                
            $sql = $db->bindVars($sql, ':customers_id', $customer->customersId, 'integer');
            
            $all_merchant = $db->Execute($sql);       
            if($all_merchant->RecordCount() > 0)
                $all_merchant = $all_merchant->fields;
            else 
                $all_merchant = array('id' => 0, 'discount_percentage' => 0, 'card_discounts_id' => 0);
                
            $this->view->setVars(array('result_list' => $result_list, 'all_merchant' => $all_merchant));                         
        }
        
        $this->view->get('php::holder')->add('main', $this->view->render('riCard::_admin_discount_main_slot', array('customer' => $customer)));

        return $this->render('riCard::admin_layout');
    }
}