<?php

namespace plugins\riCard;

use plugins\riPlugin\Object;
use plugins\riCard\Card;

/**
 * 
 * Clas card order
 * @author vunguyen
 *
 */
class CardOrder extends Object{	
	
	private $info, $cards;
	
    /**
     * 
     * Create a new card object
     * @param cards object $cards
     * @param payment object $payment
     * @return return Card
     */
    public function __construct($dispatcher, $cards){
         $this->cards = $cards;
         $this->info = array();
    }
    
	public function create($cards, $customer, $address){					

		$this->setInfo($customer, $address);
		
		$this->cards = $cards;
		
		return $this;
	}
	
	public function save(){
		global $db;
		
		$this->info = $this->_mapInfo($this->info);

		// recalculate total
		$cards = $this->cards->getAll();
		$total = $this->container->get('riCard.CardPayment')->calculateTotal($cards);
		$this->info = array_merge($this->info, array(					
			'face_value' => $total['face_value'],
			'cash_value' => $total['cash_value'],						
			'paypal_value' => $total['paypal_value'],
			'amazon_value' => $total['amazon_value'],
			'amazon_fee' => $total['amazon_fee']
		));
		
		// insert into db		
		if(!isset($this->id)){
			zen_db_perform(TABLE_CARD_ORDERS, $this->info);
			$this->id = $db->Insert_ID();
		}
		else{
			$this->info['last_modified'] = 'now()';
			zen_db_perform(TABLE_CARD_ORDERS, $this->info, 'update', 'card_orders_id = '.$this->id);
			//$db->Execute("DELETE FROM ".TABLE_CARD_ORDERS_CARDS." WHERE card_orders_id = ".$this->id);
		}
		
		foreach($cards as $card){
			$card->cardOrdersId = $this->id;
			$card->save();						
		}
		return $this;
	}
	
	
	public function getInfo(){
		return $this->info;
	} 
		
	public function setInfo($address, $customer){
	    $data = array('customers_id' => $customer->customersId,
							'name' => $customer->customersFirstname . ' ' . $customer->customersLastname,
							'street_address' => $address->entryStreetAddress,
							'suburb' => $address->entrySuburb,
							'city' => $address->entryCity,
							'state' => !empty($address->entryState) ? $address->entryState : $address->getZone()->zoneCode,
							'country' => $address->getCountry()->countriesName,
							'postcode' => $address->entryPostcode,
							'phone' => $customer->customersTelephone,														
							'email' => $customer->customersEmailAddress,
							'date_purchased' => 'now()',
							'card_orders_status' => 1
	    );
	    
	    $this->setInfoByArray($data);	    
	}
	
	public function setInfoByArray($data){
	   $this->info = array_merge($this->info, $data); 
	}
	
    public function setInfoField($key, $value){
		$this->info[$key] = $value;
	}
	
    public function getInfoField($key, $default = null){
		return isset($this->info[$key]) ? $this->info[$key] : $default;
	}
	
	public function getCards(){
	    return $this->cards;
	}
	
	private function _mapInfo($info){
		$map = array(
			'customers_id' => '',
			'name' => '',
			'street_address' => '',
			'suburb' => '',
			'city' => '',
			'state' => '',
			'country' => '',
			'postcode' => '',
			'phone' => '',													
			'email' => '',
			'type' => '',
			'pay_type' => '',
			'routing_number' => '',
			'account_number' => '',
			'payment_email' => '',
			'face_value' => '',
			'cash_value' => '',						
			'paypal_value' => '',
			'amazon_value' => '',
			'amazon_fee' => '',
			'date_purchased' => 'now()',
			'date_completed' => '',
			'card_orders_status' => '',
			'surcharge' => '',
			'last_modified' => '',
			'mass_pay' => '',
		    'affiliates_id' => '',
			'comment' => ''
		);		
		
		$temp = array();
		foreach ($map as $key => $value){			
			if(isset($info[$key])) $temp[$key] = $info[$key];
			elseif(!empty($map[$key])) $temp[$key] = $map[$key];			
		}
		
		return $temp;
	}
	
	public function getArray(){
	    return array('info' => $this->info, 'cards' => $this->cards->getCards());
	}
	
	public function setArray($data){
	    $this->info = $data['info'];
	    $this->cards = $this->container->get('riCard.Cards')->setCards($data['cards']);
	}
	
    public function mail(){
	    // for amazon trade
	    if($this->type == 2){
    		$email_text .= "\n\n" ."Thank you for your recent order to sell your gift cards. 
    		Please find attached a sell form which should be signed and inserted with your package. \n\n
    		Once your cards are received by our processing center and upon verification we will issue payment to the payment method you requested, within 24 hours.\n\n
    		Please ship you card(s) to"."\n"."ABC Processing Center"."\n"."2275 WEST COUNTY LINE RD,"."\n"."STE 6. RM 315.\n
    		JACKSON, NJ 08527\n\n
    		You can send it to us with regular first class mail.\n
    		If you are sending a large amount we recommend, for your added, protection to add delivery confirmation to you package. 
    		This option is available in any Post Office, at <a href='www.USPS.com'>www.USPS.com</a> (available only for Priority Mail), or for PayPal users by clicking on the link below (available even for First Class Mail)  <a href='https://www.paypal.com/us/cgi-bin/websrc?cmd=_ship-now'>https://www.paypal.com/us/cgi-bin/websrc?cmd=_ship-now</a>\n\n\n\n
    		Link confirm order :<a href='%s'>Click here</a>";
	    }
	    // for others
	    else{
	        $email_text .= "\n\n" ."Thank you for your recent order to sell your gift cards. 
    		Please find attached a sell form which should be signed and inserted with your package. \n\n
    		Once your cards are received by our processing center and upon verification we will issue payment to the payment method you requested, within 24 hours.\n\n
    		Please ship you card(s) to"."\n"."ABC Processing Center"."\n"."2275 WEST COUNTY LINE RD,"."\n"."STE 6. RM 315.\n
    		JACKSON, NJ 08527\n\n
    		You can send it to us with regular first class mail.\n
    		If you are sending a large amount we recommend, for your added, protection to add delivery confirmation to you package. 
    		This option is available in any Post Office, at <a href='www.USPS.com'>www.USPS.com</a> (available only for Priority Mail), or for PayPal users by clicking on the link below (available even for First Class Mail)  <a href='https://www.paypal.com/us/cgi-bin/websrc?cmd=_ship-now'>https://www.paypal.com/us/cgi-bin/websrc?cmd=_ship-now</a>\n\n\n\n
    		Link confirm order :<a href='%s'>Click here</a>";
	    }
		$email_text = sprintf($email_text, zen_href_link('confirm_infomation.php', 'sys_id='.$this->id, 'SSL', false, true, true));
	
	    zen_mail(STORE_NAME, EMAIL_FROM, "Sell Gift Cards Order Confirmation #".$this->id, $email_text, STORE_NAME, EMAIL_FROM, '', "welcome");
		//--------CC email customer-----------//
		zen_mail($this->info['fullname'], $this->info['email'], "Sell Gift Cards Order Confirmation #".$this->id, $email_text, STORE_NAME, EMAIL_FROM);
	}
}