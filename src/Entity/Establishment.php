<?php

namespace kids\Entity;

class App_Model_Establishment
{

    protected $_id;
    protected $_name;
    protected $_address_id;



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

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getAddressId()
    {
        return $this->_address_id;
    }

    public function setAddressId($addressId)
    {
        $this->_address_id = $addressId;
        return $this;
    }



}
