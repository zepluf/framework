<?php

namespace Proxies\__CG__\Zepluf\Bundle\StoreBundle\Entity;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class ContactMechanism extends \Zepluf\Bundle\StoreBundle\Entity\ContactMechanism implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function setAddress1($address1)
    {
        $this->__load();
        return parent::setAddress1($address1);
    }

    public function getAddress1()
    {
        $this->__load();
        return parent::getAddress1();
    }

    public function setAddress2($address2)
    {
        $this->__load();
        return parent::setAddress2($address2);
    }

    public function getAddress2()
    {
        $this->__load();
        return parent::getAddress2();
    }

    public function setCity($city)
    {
        $this->__load();
        return parent::setCity($city);
    }

    public function getCity()
    {
        $this->__load();
        return parent::getCity();
    }

    public function setState($state)
    {
        $this->__load();
        return parent::setState($state);
    }

    public function getState()
    {
        $this->__load();
        return parent::getState();
    }

    public function setAreaCode($areaCode)
    {
        $this->__load();
        return parent::setAreaCode($areaCode);
    }

    public function getAreaCode()
    {
        $this->__load();
        return parent::getAreaCode();
    }

    public function setCountryCode($countryCode)
    {
        $this->__load();
        return parent::setCountryCode($countryCode);
    }

    public function getCountryCode()
    {
        $this->__load();
        return parent::getCountryCode();
    }

    public function setElectronicAddress($electronicAddress)
    {
        $this->__load();
        return parent::setElectronicAddress($electronicAddress);
    }

    public function getElectronicAddress()
    {
        $this->__load();
        return parent::getElectronicAddress();
    }

    public function setContactMechanismType(\Zepluf\Bundle\StoreBundle\Entity\ContactMechanismType $contactMechanismType = NULL)
    {
        $this->__load();
        return parent::setContactMechanismType($contactMechanismType);
    }

    public function getContactMechanismType()
    {
        $this->__load();
        return parent::getContactMechanismType();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'address1', 'address2', 'city', 'state', 'areaCode', 'countryCode', 'electronicAddress', 'contactMechanismType');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}