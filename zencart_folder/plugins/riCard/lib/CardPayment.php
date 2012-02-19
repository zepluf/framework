<?php 

namespace plugins\riCard;

use plugins\riPlugin\Object;
use plugins\riPlugin\Plugin;
use plugins\riCard\Cards;

class CardPayment extends Object{	
	/*
	 * array ('fullname' => $customerInfo->fields['customers_firstname'] . ' ' . $customerInfo->fields['customers_lastname'], 
														'email' => $customerInfo->fields['customers_email_address'],
														'address' => $customerInfo->fields['entry_street_address'],
														'address2' => $customerInfo->fields['entry_suburb'],
														'city' => $customerInfo->fields['entry_city'],
														'state' => $customerInfo->fields['zone_code'],
														'zip' => $customerInfo->fields['entry_postcode'],
														'home_phone' => $customerInfo->fields['customers_telephone'],
														'mobile_phone' => $customerInfo->fields['customers_telephone']		
														 );
	 * 
	 */
	
	public function calculateTotal($cards){
		$total = array('face_value' => 0, 'amazon_value' => 0, 'amazon_fee' => 0, 'cash_value', 'paypal_value' => 0);
		
		if(count($cards) > 0){			
			foreach($cards as $card){
				$total['face_value'] += $card->faceValue;
				$total['amazon_value'] += $card->amazonValue;
				$total['amazon_fee'] += $card->amazonFee;
				$total['cash_value'] += $card->cashValue;
				$total['paypal_value'] += $card->paypalValue;								
			}			
		}
		
		return $total;
	}
	
	public function setAddress($address, $customer){
		$this->address = array (
				'name' => $address->entryCustomersFirstname . ' ' . $address->entryCustomersLastname, 
				'email' => $customer->customersEmailAddress,
				'street_address' => $address->entryStreetAddress,
				'suburb' => $address->entrySuburb,
				'city' => $address->entryCity,
				'state' => $address->zoneState,
				'postcode' => $address->entryPostcode,
				'country' => $address->getCountry()->countriesName,
				'phone' => $customer->customersTelephone						
			);
	}
}