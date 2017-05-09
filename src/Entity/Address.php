<?php

namespace kids\Entity;

class App_Model_Address
{

    protected $_id;
    protected $_address;
    protected $_complement;
    protected $_city;
    protected $_zipcode;


    /**
     * GETTERS / SETTERS
     */
    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getAddress()
    {
        return $this->_address;
    }

    public function setAddress($address)
    {
        $this->_address = $address;
        return $this;
    }

    public function getComplement()
    {
        return $this->_complement;
    }

    public function setComplement($complement)
    {
        $this->_complement = $complement;
        return $this;
    }

    public function getCity()
    {
        return $this->_city;
    }

    public function setCity($city)
    {
        $this->_city = $city;
        return $this;
    }

    public function getZipcode()
    {
        return $this->_zipcode;
    }

    public function setZipcode($zipcode)
    {
        $this->_zipcode = $zipcode;
        return $this;
    }



}
