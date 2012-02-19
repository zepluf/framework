<?php 

namespace plugins\riCard;

use plugins\riPlugin\Object;

use plugins\riCard\Card;

class Cards extends Object{	

	private $cards = array();
	
	public function setCards($cards){
		$this->cards = $cards;
		return $this;
	}
	
	public function getCards(){
		return $this->cards;	
	}
	
	public function removeAll(){
	    $this->cards = array();
	}
	
	public function add(Card $card){		
		$data = $card->getArray();		
		// we need to do this so we can easily store everything in session	
		$data['merchant'] = $card->merchant->getArray();
		$this->cards[$card->uid] = $data;		
	}
	
	public function removeByGId($gid){
		foreach($this->cards as $uid => $card){
			if($card['gid'] == $gid) unset($this->cards[$uid]);
		}
	}
	
	public function setByUId($uid, $key, $value){
		if(isset($this->cards[$uid]))
			$this->cards[$uid][$key] = $value;	
		return $this;	
	}
	
	public function getByUId($uid){
		return $this->toCardObject($this->cards[$uid]);
	}
	
	public function count(){
		return count($this->cards);
	}
	
	private function toCardObject($data){
		$card = $this->container->get('riCard.Card');				
		$data['merchant'] = $this->container->get('riMerchant.Merchant')->setArray($data['merchant']);
		$card->setArray($data);
		
		return $card;
	}
	
	public function groupByMerchantValue($cards){
		$groups = array();
		if(is_array($cards))
		foreach($cards as $card){							
			$groups[$card->gid][] = $card;							
		}
		return $groups;
	}
	
	public function groupByMerchantId($cards){
		$groups = array();
		
		foreach($cards as $card){							
			$groups[$card->merchant->id][] = $card;							
		}
		return $groups;
	}
		
	public function getAll(){
		$cards = array();//echo "<pre>";var_dump($this->cards);echo "</pre>";die();
		if(isset($this->cards) && is_array($this->cards)){
			foreach($this->cards as $data){				
				$cards[] = $this->toCardObject($data);				
			}
		}
		return $cards;
	}
	
	public function setAll(){
	    
	}
	
	public function deleteByUId($uid){
		if(isset($this->cards[$uid])){		
			if(!empty($this->cards[$uid]['id']) && !empty($this->cards[$uid]['card_orders_id'])){
				global $db;
				$sql = "DELETE FROM ".TABLE_CARD_ORDERS_CARDS." WHERE card_orders_id = :card_orders_id AND id=:id";
				$sql = $db->bindVars($sql, ':card_orders_id', $this->cards[$uid]['card_orders_id'], 'integer');
				$sql = $db->bindVars($sql, ':id', $this->cards[$uid]['id'], 'integer');
				$db->Execute($sql);
			}
			
			unset($this->cards[$uid]);
			
			return true;
		}
		return false;
	}
}