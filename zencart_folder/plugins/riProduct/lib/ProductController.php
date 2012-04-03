<?php

namespace plugins\riProduct;

use Symfony\Component\HttpFoundation\Request;

use plugins\riSimplex\Controller;
use plugins\riPlugin\Plugin;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller{
	
	public function AjaxFindByNameAction(Request $request) {
		$products = Plugin::get('riProduct.Products')->findByName($request->get('term'));
		$data = array();
		foreach ($products as $product){
			$data[] = array('id' => $product->getProductsId(), 'label' => $product->getDescription()->getProductsName());
		}
		return new Response(json_encode(
        	$data
        ));   
	}
	
	
	
	/*public function index(Request $request){
		
		Plugin::load(array('riResultList'));
	 
		$result_list = Plugin::get('riResultList.ResultList');
		$result_list->setPagination(50);

		$merchants = Plugin::get('riMerchant.Merchants');
			  	
		$result_list->setResultSource($merchants); 
			
		$result_list->setPageNumber($request->get('page', 1));		
		
		// create new metchant?
		if($request->get('sub_action') == 'create'){
		    $merchant = Plugin::get('riMerchant.Merchant')->setArray(array(	                
	            	'categories_id' => (int)$request->get('merchants_categories_id'),
	            	'name' => $request->get('merchants_name'),
	                'buyback_percentage' => (float)$request->get('merchants_percentage')
	            ))->save();
		}
		
		elseif($request->get('sub_action') == 'mass_update'){ 
		    foreach($request->get('merchants') as $id => $info){
		        $merchant = Plugin::get('riMerchant.Merchants')->findById($id);
		        if($info['delete'] == 1)
		            $merchant->delete();
		        else{		    
		            $merchant->setArray($info['data']);
		            $merchant->save();
		        }
		    }
		}
		
	    if((int)$request->get('merchants_id') > 0){	
	        $result_list->addFilter('id = '.(int)$request->get('merchants_id'));	    				   
		}
		
		$this->view->get('php::holder')->add('main', $this->view->render('riMerchant::_index.php', array('result_list' => $result_list, 'merchant' => $merchant, 'merchants' => $merchants, 'current_route' => $request->get('_route'))));
		
		return $this->render('riMerchant::admin_layout');
	}
	
	public function import(Request $request){
	    if($request->getMethod() == "POST"){
	        $data = Plugin::get('riCsv.Csv')->import($request->files->get('file'));
	        foreach ($data as $row){
	            $merchant = Plugin::get('riMerchant.Merchant')->setArray(array(
	                'id' => (int)$row[0],
	            	'categories_id' => (int)$row[1],
	            	'name' => $row[2],
	                'buyback_percentage' => $row[3]
	            ))->save();
	        }	  
	        $this->view->get('php::holder')->add('main', ri('proccesed %count% rows', array('%count%' => count($data))));   
	    }
	    $this->view->get('php::holder')->add('main', $this->view->render('riMerchant::_import'));
	    
	    return $this->render('riMerchant::admin_layout');
	}
	
    public function export(Request $request){
        global $db;

        $sql = "SELECT * FROM ".TABLE_CARD_MERCHANTS. " order by name";
        $result = $db->Execute($sql);
            	        
        $data = Plugin::get('riUtility.Utility')->dbToArrayWithoutKey($result);
            	
        //array_unshift($data, array_keys($result->fields));
            	
        $filedata = Plugin::get('riCsv.Csv')->export($data);
            	
        return new Response(
        $filedata,
        200,
        array(
                 'Content-Type' => 'application/csv', 
                 'Content-Disposition' => sprintf('attachment; filename="%s.csv"', 'merchants') 
        ));        
    }*/
}