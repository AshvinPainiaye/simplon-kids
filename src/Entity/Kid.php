<?php

namespace Kids\Entity;

use Kids\Config\Database;
use PDO;


class Kid extends Database
{

    protected $_id;
    protected $_firstname;
    protected $_lastname;
    protected $_birthday;
    protected $_classroom;
    protected $connexion;


    public function save()
    {
      $connexion =  $this->getConnexion();

      $firstname = $this->getFirstname();
      $lastname = $this->getLastname();
      $birthday = $this->getBirthday();
      $classroom = $this->getClassroom();

      try {

        $sql = "INSERT INTO kid (firstname, lastname, birthday, classroom) VALUE (:firstname, :lastname, :birthday, :classroom)";
        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':birthday',$birthday);
        $stmt->bindParam(':classroom', $classroom);
        $stmt->execute();

        $lastId =  $connexion->lastInsertId();
        $this->setId($lastId);

      } catch (Exception $e) {
        echo $e->getMessage();
      }

    }


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
