<?php 

namespace plugins\riCard;

use plugins\riPlugin\Object;

use plugins\riPlugin\Plugin;

class Card extends Object{

	/*
	 * 
	 */
	public function create($merchant_id, $face_value, $seed=''){		
		$merchant_id = abs((int)$merchant_id);
		$face_value = abs((float)$face_value);
		
		if($merchant_id == 0 || $face_value == 0) return false;
		$quantity = abs((int)$quantity);
		
		$merchants = $this->container->get('riMerchant.Merchants');
		
		if(($merchant = $merchants->findById($merchant_id)) === false){
			
			$this->container->get('riLog.Logs')->add(array('message' => 'merchant not found', 'session' => true));
			return false;
		}
		$this->merchant = $merchant;								
		$this->faceValue = $face_value;						
		$this->status = 0;
		$this->uid = empty($uid) ? md5($this->merchant->id .'_'. $this->faceValue .'_'. time() .'_'. $seed) : $uid;
		$this->init();
		$this->calculateBuybackPercentage();
		return $this;
	}
	
	public function setId($id){
	    $this->id = $id;
	}
	
	public function getId($id){
	    return $this->id;    
	}
	
	private function calculateBuybackPercentage(){
		$this->buybackPercentage = $this->container->get('riCard.Price')->getDiscount($this->merchant->id, $this->merchant->buybackPercentage);
	}
	
	public function init(){								
		$this->gid = md5($this->merchant->id .'_'. $this->faceValue);		
		$this->amazonFee = $this->getAmazonFee();		
		$this->cashValue = $this->getCashValue();				
		$this->paypalValue = $this->getPaypalValue();
		$this->amazonValue = $this->getAmazonValue();	
	}	
	
	public function setArray($data){		
		parent::setArray($data);
		$this->init();		
		// if the percentage is already set we do not re-calculate it
		if(!isset($this->buybackPercentage))
			$this->calculateBuybackPercentage();
			
		return $this;
	}	
	
	public function save(){
		global $db;
		if(isset($this->cardOrdersId) && $this->cardOrdersId > 0){
			$data = array('card_orders_id' => $this->cardOrdersId,
					'merchants_name' => $this->merchant->name,
					'merchants_id' => $this->merchant->id,
					'face_value' => $this->faceValue,
					'cash_value' => $this->cashValue,
					'amazon_value' => $this->amazonValue,
					'amazon_fee' => $this->amazonFee,
					'buyback_percentage' => $this->buybackPercentage,
					'paypal_value' => $this->paypalValue,
					'number' => $this->number,
					'pin' => $this->pin,
					'status' => $this->status
					);
					
			if(isset($this->id) && $this->id > 0)
				zen_db_perform(TABLE_CARD_ORDERS_CARDS, $data, 'update', 'id = '.$this->id);
			else {
				zen_db_perform(TABLE_CARD_ORDERS_CARDS, $data);
				$this->id = $db->Insert_ID();
			}
			return true;
		}
		return false;
	}
	
	public function createProduct($orders_id){		
		if(!isset($this->merchant->categoriesId) || $this->merchant->categoriesId <= 0){
			$this->container->get('riLog.Logs')->add(array('message' => ri('invalid master category for merchant %name%', array('%name%' => $this->merchant->name))));
			return false;
		}
		// find the sample product
		global $db;	
		$sql = "SELECT products_id FROM ".TABLE_PRODUCTS." WHERE master_categories_id = :categories_id AND products_model = 'test' LIMIT 1";
		$sql = $db->bindVars($sql, ":categories_id", $this->merchant->categoriesId, 'integer');
					
		$result = $db->Execute($sql);
		if($result->RecordCount() > 0){
			\plugins\riPlugin\Plugin::load('riProduct');
			$product = $this->container->get('riProduct.Products')->findById($result->fields['products_id']);
			if($product !== false){
			    $product = clone $product;
			    // set products price
			    $product->productsPrice = $this->faceValue;
			    $product->productsModel = $orders_id;
			    
			    // update the name
				$description = $product->getDescription();
				
				// extract the dollar ammount in string
				$pat = '/\$([0-9]+[\.]*[0-9]*)/';				
				            
    		    if(preg_match($pat, $description->productsName, $matches)){
				    $description->productsName = trim(str_replace($matches[0], '$'.number_format($this->faceValue, 2) , $description->productsName));				    
    		        $product->setDescription($description);
    		    }
						
				$product->productsId = 0;
				$product->productsQuantity = 1;
				$product->productsStatus = 1;	
				if($product->save()){
				    // save card info
					$this->status = 1;
					$this->save();
					return $product;
				}	
				$this->container->get('riLog.Logs')->add(array('message' => 'failed to save product'));
				return false;			
			}
		}

		else {
			$this->container->get('riLog.Logs')->add(array('message' => 'sample product not found in category:' . $this->merchant->categoriesId . ' for ' . $this->merchant->name));
		}
		return false;
	}
	
	/*
	 * pricing
	 */
	public function getCashValue(){
		return $this->buybackPercentage/100 * $this->faceValue;
	}

	public function getAmazonValue(){
		return $this->buybackPercentage/100 * $this->faceValue * 1.05;
	}
	
	public function getPaypalValue(){
		$cash_value = $this->getCashValue($this->faceValue);
		return $cash_value + $cash_value * 0.029;
	}
	
	public function getAmazonFee(){
		return $this->faceValue - $this->faceValue * 1.05 * $this->buybackPercentage/100;		
	}
}