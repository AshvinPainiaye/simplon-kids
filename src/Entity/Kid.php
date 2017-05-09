<?php

namespace kids\Entity;

class App_Model_Kid
{

    protected $_id;
    protected $_firstname;
    protected $_lastname;
    protected $_birthday;
    protected $_classroom;


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

    public function getBirthday()
    {
        return $this->_birthday;
    }

    public function setBirthday($birthday)
    {
        $this->_birthday = $birthday;
        return $this;
    }

    public function getClassroom()
    {
        return $this->_classroom;
    }

    public function setClassroom($classroom)
    {
        $this->_classroom = $classroom;
        return $this;
    }



}
