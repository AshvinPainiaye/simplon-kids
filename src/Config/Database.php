<?php
namespace kids\Config;

use PDO;
use PDOException;


class Database{

  private $pdo;

  public $hostname = 'localhost';
  public $db_username = 'root';
  public $db_password = '';
  public $db_name = 'eval_kids';


  public function getConnexion(){

    try {
      $this->connexion = new PDO("mysql:host=$this->hostname;dbname=$this->db_name", $this->db_username, $this->db_password);
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
      echo $e->getMessage();
    }
    return $this->connexion;
  }
}
