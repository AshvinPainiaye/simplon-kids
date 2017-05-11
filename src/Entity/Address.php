<?php

namespace kids\Entity;

use kids\Config\Database;
use PDO;

class Address
{

    protected $_id;
    protected $_address;
    protected $_complement;
    protected $_city;
    protected $_zipcode;
    protected $connexion;

    public function __construct()
    {
      $db = new Database();
      $this->connexion =  $db->getConnexion();
    }

    public function save()
    {
      $connexion =  $this->connexion;

      $address = $this->getAddress();
      $complement = $this->getComplement();
      $city = $this->getCity();
      $zipcode = $this->getZipcode();

      try {

        $sql = "INSERT INTO address (address, complement, city, zipcode) VALUE (:address, :complement, :city, :zipcode)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':complement', $complement);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':zipcode', $zipcode);
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
