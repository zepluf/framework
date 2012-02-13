<?php 

namespace plugins\riCustomer;

use Symfony\Component\HttpFoundation\Request;

use plugins\riSimplex\Controller;
use plugins\riPlugin\Plugin;
use Symfony\Component\HttpFoundation\Response;

class AdminCustomerController extends Controller{
    public function export(Request $request){
        if($request->getMethod() == 'GET'){
            $this->view->get('php::holder')->add("main", $this->render("riCustomer::_admin_export_filters"));
            return $this->render("riCustomer::admin_layout");
        }
        else{
            
            global $db;
            
            $result_list = Plugin::get('riResultList.ResultList');
            $result_list->setPagination(0); // unlimit
            
            switch($request->get("type")){
                case "category":
            
                    $sql = "SELECT customers_name, customers_email_address, SUM( op.products_price * op.products_quantity ) AS total_amount_ordered ". 
                        " FROM " . TABLE_ORDERS . " o," . TABLE_ORDERS_PRODUCTS . " op," . TABLE_PRODUCTS_TO_CATEGORIES . " p2c";
                        
                    $result_list->addFilter("o.orders_id = op.orders_id");
                    $result_list->addFilter("op.products_id = p2c.products_id");            
                    
                    $result_list->addFilters($request->get('filters', array()), array(
                    	'categories_id' => array('condition' => '=', 'field' => 'p2c.categories_id'),
                        'date_from' => array('condition' => ' >= ', 'field' => 'o.date_purchased', 'bind' => function($v){ return "'$v 00:00:00'";}),
                        'date_to' => array('condition' => ' <= ', 'field' => 'o.date_purchased', 'bind' => function($v){ return "'$v 23:59:59'";})                         
                    ));
                                                               
                    $sql = $result_list->buildPaginationQuery($sql);
                    
                    $sql .= " group by o.customers_id";
                    
                    break;               
                
                case "never":
                    $sql = "SELECT CONCAT_WS(' ', c.customers_firstname, c.customers_lastname) AS name , c.customers_email_address, ci.customers_info_date_account_created 
                    	FROM " . TABLE_CUSTOMERS . " c," . TABLE_CUSTOMERS_INFO . " ci ";
                    
                    $result_list->addFilter("c.customers_id = ci.customers_info_id");
                    $result_list->addFilter("c.customers_id NOT IN (SELECT DISTINCT customers_id FROM " . TABLE_ORDERS . ")");
                    $sql = $result_list->buildPaginationQuery($sql);
                    break;
                    
                case "last":
                    $sql = "SELECT o.customers_name , o.customers_email_address, MAX(o.date_purchased) as date_purchased, COUNT(*) AS total_order 
                    	FROM " . TABLE_ORDERS . " o";
                    
                    $result_list->addFilters($request->get('filters', array()), array(
                        'date_from' => array('condition' => ' >= ', 'field' => 'o.date_purchased', 'bind' => function($v){ return "'$v 00:00:00'";}),
                        'date_to' => array('condition' => ' <= ', 'field' => 'o.date_purchased', 'bind' => function($v){ return "'$v 23:59:59'";})
                         )
                    );
                                         
                     $sql = $result_list->buildPaginationQuery($sql);
                     $sql .= " GROUP BY o.customers_id ORDER BY o.customers_name";                  
                    break;                    
            }
            $result = $db->Execute($sql);
            
            $data = Plugin::get('riUtility.Utility')->dbToArrayWithoutKey($result);
            
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
    }
}