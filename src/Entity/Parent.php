<?php

namespace kids\Entity;

class App_Model_Parent
{

    protected $_id;
    protected $_firstname;
    protected $_lastname;
    protected $_email;
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

    public function getFirstname()
    {
        return $this->_firstname;
    }

    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
        return $this;
    }

    public function getLastname()
    {
        return $this->_lastname;
    }

    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
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
