<?php

namespace Tests\app;

use PDO;

class EstablishmentTest extends DatabaseTest
{

  /**
  * Recupere la liste des etablissements
  *
  */
  function testFetchAllEstablishment() {
    $connexion =  $this->getConnection();
    $sql = "SELECT * FROM establishment";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $expected = array(
      array(
        'id' =>  '1',
        'name' =>  'College Quartier Francais',
        'address_id' => '2'
      ),
      array(
        'id' =>  '2',
        'name' =>  'College Lucet Langenier',
        'address_id' => '3'
      ),

    );

    $this->assertEquals($expected, $results);
  }


  /**
  * Recupere un etablissements
  *
  */
  function testFindWorkshop() {
    $id = 1;
    $connexion =  $this->getConnection();
    $sql = "SELECT e.id, e.name, a.address, a.complement, a.city, a.zipcode
    FROM establishment as e
    JOIN address a
    ON e.address_id = a.id
    WHERE e.id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $id));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $expected = array(
        'id' =>  '1',
        'name' =>  'College Quartier Francais',
        'address' => '10 rue des goyave',
        'complement' => '',
        'city' => 'Saint-Denis',
        'zipcode' => '97400'
    );

    $this->assertEquals($expected, $result);
  }

}
