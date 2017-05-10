<?php

namespace kids\Entity;

use kids\Config\Database;
use PDO;

class ParentOfKid
{

  protected $_id;
  protected $_firstname;
  protected $_lastname;
  protected $_email;
  protected $_address_id;
  protected $_phone;
  protected $connexion;

  public function __construct()
  {
    $db = new Database();
    $this->connexion =  $db->getConnexion();
  }


  public function save()
  {
    $connexion =  $this->connexion;

    $firstname = $this->getFirstname();
    $lastname = $this->getLastname();
    $email = $this->getEmail();
    $addressId = $this->getAddressId();
    $phone = $this->getPhone();

    try {

      $sql = "INSERT INTO `parent` (`firstname`, `lastname`, `email`, `address_id`, `phone`) VALUE (:firstname, :lastname, :email, :address_id, :phone)";

      $stmt = $connexion->prepare($sql);

      $stmt->bindParam(':firstname', $firstname);
      $stmt->bindParam(':lastname', $lastname);
      $stmt->bindParam(':email',$email);
      $stmt->bindParam(':address_id', $addressId);
      $stmt->bindParam(':phone', $phone);
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

  public function getPhone()
  {
    return $this->_phone;
  }

  public function setPhone($phone)
  {
    $this->_phone = $phone;
    return $this;
  }

}
