<?php

namespace Zepluf\Bundle\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactMechanism
 *
 * @ORM\Table(name="contact_mechanism")
 * @ORM\Entity
 */
class ContactMechanism
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="address_1", type="string", length=255, nullable=true)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address_2", type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="area_code", type="string", length=255, nullable=true)
     */
    private $areaCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=45, nullable=true)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="electronic_address", type="string", length=255, nullable=true)
     */
    private $electronicAddress;

    /**
     * @var \ContactMechanismType
     *
     * @ORM\ManyToOne(targetEntity="ContactMechanismType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_mechanism_type_id", referencedColumnName="id")
     * })
     */
    private $contactMechanismType;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return ContactMechanism
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    
        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return ContactMechanism
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    
        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ContactMechanism
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return ContactMechanism
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set areaCode
     *
     * @param string $areaCode
     * @return ContactMechanism
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;
    
        return $this;
    }

    /**
     * Get areaCode
     *
     * @return string 
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return ContactMechanism
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    
        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set electronicAddress
     *
     * @param string $electronicAddress
     * @return ContactMechanism
     */
    public function setElectronicAddress($electronicAddress)
    {
        $this->electronicAddress = $electronicAddress;
    
        return $this;
    }

    /**
     * Get electronicAddress
     *
     * @return string 
     */
    public function getElectronicAddress()
    {
        return $this->electronicAddress;
    }

    /**
     * Set contactMechanismType
     *
     * @param \Zepluf\Bundle\StoreBundle\Entity\ContactMechanismType $contactMechanismType
     * @return ContactMechanism
     */
    public function setContactMechanismType(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanismType $contactMechanismType = null)
    {
        $this->contactMechanismType = $contactMechanismType;
    
        return $this;
    }

    /**
     * Get contactMechanismType
     *
     * @return \Zepluf\Bundle\StoreBundle\Entity\ContactMechanismType 
     */
    public function getContactMechanismType()
    {
        return $this->contactMechanismType;
    }
}