<?php

namespace Tests\app;

use PDO;
use Kids\Entity\Establishment;

class EstablishmentTest extends DatabaseTest
{

  /**
  * Recupere la liste des etablissements
  *
  */
  function testFetchAllEstablishment() {

    $establishment = new establishment();
    $actual = $establishment->fetchAll();

    $expected = array(

      array(
        "id"=> "1",
        "name"=>  "College Quartier Francais",
        "address"=> "10 rue des goyave",
        "complement"=>  "",
        "city"=> "Saint-Denis",
        "zipcode"=>  "97400"
      ),

      array(
        "id"=>  "2",
        "name"=>  "College Lucet",
        "address"=>  "Avenue des letchi",
        "complement"=>  "",
        "city"=>  "Saint-Pierre",
        "zipcode"=> "97410"
      ),

      array(
        "id"=>  "3",
        "name"=>  "Ecole 2 canon",
        "address"=> "Rue des kebab",
        "complement"=>  "chemin 4",
        "city"=> "Saint-André",
        "zipcode"=> "97490"
      )

    );

    $this->assertEquals($expected, $actual);
  }


  /**
  * Recupere un etablissements
  *
  */
  function testFindEstablishment() {
    $establishment = new establishment();
    $actual = $establishment->find(1);

    $expected = array(
        'id' =>  '1',
        'name' =>  'College Quartier Francais',
        'address' => '10 rue des goyave',
        'complement' => '',
        'city' => 'Saint-Denis',
        'zipcode' => '97400'
    );

    $this->assertEquals($expected, $actual);
  }

}
