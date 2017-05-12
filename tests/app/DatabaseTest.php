<?php

namespace tests\app;
use PDO;

class DatabaseTest extends \PHPUnit_Framework_TestCase
{

  public $connection = null;

  function testGetConnection() {
      $this->connexion = new PDO('mysql:host=localhost;dbname=eval_kids_test', 'root', '');
      $this->assertNotNull($this->connexion);
  }


  public function getConnection() {
      $this->connection = new PDO('mysql:host=localhost;dbname=eval_kids_test', 'root', '');
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $this->connection;
  }


}
