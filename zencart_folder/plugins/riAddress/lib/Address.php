<?php

namespace plugins\riAddress;

use plugins\riPlugin\Model;

class Address extends Model{
    public function getCountry(){
        if(!isset($this->country))
            $this->country = $this->container->get('riAddress.Countries')->findById($this->entryCountryId);
        return $this->country;
    }		
}