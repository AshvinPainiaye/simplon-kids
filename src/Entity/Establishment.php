<?php

namespace kids\Entity;

use kids\Config\Database;
use PDO;

class Establishment
{

  protected $_id;
  protected $_name;
  protected $_address_id;

  protected $connexion;

  public function __construct()
  {
    $db = new Database();
    $this->connexion =  $db->getConnexion();
  }


  public function fetchAll()
  {
    $connexion =  $this->connexion;

    $sql = "SELECT id FROM establishment";

    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll();
    $return = array();
    foreach($results as $result)
    {
      $return[] = $this->find($result['id']);
    }

    return $return;
  }


  public function find($id)
  {
    $connexion =  $this->connexion;

    $sql = "SELECT e.id, e.name, a.address, a.complement, a.city, a.zipcode
    FROM establishment as e
    JOIN address a
    ON e.address_id = a.id
    WHERE e.id = :id";

    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
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
