<?php


class DatabaseTest extends \PHPUnit_Framework_TestCase
{

  private $connection = null;

  function testGetConnection() {
      $this->connexion = new PDO('mysql:host=localhost;dbname=eval_kids_test', 'root', '');
      $this->assertNotNull($this->connexion);
  }

}
