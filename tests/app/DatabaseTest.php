<?php

namespace Tests\app;
use PDO;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{

  public $connection = null;

  function testGetConnection() {
      $this->connexion = new PDO('mysql:host=localhost;dbname=eval_kids_test', 'root', '');
      $this->assertNotNull($this->connexion);
  }


  public function getConnection() {
    try {
      $this->connection = new PDO('mysql:host=localhost;dbname=eval_kids_test', 'root', '');
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->connection;
  }


}
