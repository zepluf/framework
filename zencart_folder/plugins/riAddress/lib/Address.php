<?php

namespace plugins\riAddress;

use plugins\riPlugin\Model;

class Address extends Model{
    
    protected $country, $zone;
    
    public function getCountry(){
        if(empty($this->country))
            $this->country = $this->container->get('riAddress.Countries')->findById($this->entryCountryId);
        return $this->country;
    }		
    
    public function getZone(){
        if(empty($this->zone))
            $this->zone = $this->container->get('riAddress.Zones')->findById($this->entryZoneId);
        return $this->zone;
    }
}