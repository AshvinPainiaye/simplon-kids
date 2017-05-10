<?php

namespace kids\Entity;

use kids\Config\Database;

use PDO;

class Admin
{

  protected $_id;
  protected $_username;
  protected $_password;

  protected $connexion;

  public function __construct()
  {
    $db = new Database();
    $this->connexion =  $db->getConnexion();
  }

  public function authenticate($username, $password)
  {
    $connexion =  $this->connexion;

    $sql = "SELECT * FROM admin WHERE username = :username AND password = :password";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':password' => $password, ':username' => $username));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result != null) {
      return $result;
    }
    return false;
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

  public function getUsername()
  {
    return $this->_username;
  }

  public function setUsername($username)
  {
    $this->_username = $username;
    return $this;
  }

  public function getPassword()
  {
    return $this->_password;
  }

  public function setPassword($password)
  {
    $this->_password = $password;
    return $this;
  }



}
