<?php


class WorkshopTest extends \PHPUnit_Framework_TestCase
{

  private $connexion = null;

  public function getConnection() {
    try {
      $this->connexion = new PDO('mysql:host=localhost;dbname=eval_kids_test', 'root', '');
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $this->connexion;
  }

  /**
  * Recupere la liste des ateliers
  *
  */
  function testFetchAllWorkshop() {
    $connexion =  $this->getConnection();
    $sql = "SELECT * FROM workshop";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $expected = array(
      array(
        'id' =>  '1',
        'title' =>  'HTML',
        'description' => 'Debuter en html',
        'price' => '10.00',
        'max_kids' => '18',
        'image' => '1.jpg',
        'visible' => '1',
        'public_age_id' =>  '1',
        'establishment_id' => '1',
        'workshop_category_id' => '1'
      ),
      array(
        'id' =>  '2',
        'title' =>  'CSS',
        'description' => 'Debuter avec CSS',
        'price' => '12.00',
        'max_kids' => '20',
        'image' => '1.jpg',
        'visible' => '1',
        'public_age_id' =>  '1',
        'establishment_id' => '1',
        'workshop_category_id' => '2'
      )

    );

    $this->assertEquals($expected, $results);
  }



  /**
  * Recupere un atelier
  *
  */
  function testFindWorkshop() {

    $id = 1;
    $connexion =  $this->getConnection();
    $sql = "SELECT *, w.id as workshop_id, t.startAt as startAt, t.endAt as endAt
    FROM workshop as w
    JOIN public_age a
    ON w.public_age_id = a.id
    JOIN establishment e
    ON w.establishment_id = e.id
    JOIN workshop_category c
    ON w.workshop_category_id = c.id
    JOIN timetable t
    ON w.id = t.workshop_id
    WHERE w.id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $id));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $expected = array(
        'id' =>  '1',
        'title' =>  'HTML',
        'description' => 'Debuter en html',
        'price' => '10.00',
        'max_kids' => '18',
        'image' => '1.jpg',
        'visible' => '1',
        'public_age_id' =>  '1',
        'establishment_id' => '1',
        'workshop_category_id' => '1',
        'start' => '1',
        'end' => '18',
        'name' => 'Amateur',
        'address_id' => '2',
        'startAt' => '2017-05-09 08:30:00',
        'endAt' => '2017-05-09 16:30:00',
        'enable' => '1',
        'workshop_id' => '1'
    );
    $this->assertEquals($expected, $result);
  }



  /**
  * Créer un atelier
  *
  */
  function testNewWorkshop() {

    $connexion =  $this->getConnection();
    $sql = "INSERT INTO workshop (title, description, price, max_kids, image, visible, public_age_id, establishment_id, workshop_category_id) VALUES ('Code academy', 'Code academy !!!', 14, 12, '1.jpg', 1, 1, 1, 1)";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    $id = $connexion->lastInsertId();

    $sql = "SELECT * FROM workshop WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $id));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $expected = array(
        'id' =>  $id,
        'title' =>  'Code academy',
        'description' => 'Code academy !!!',
        'price' => '14.00',
        'max_kids' => '12',
        'image' => '1.jpg',
        'visible' => '1',
        'public_age_id' =>  '1',
        'establishment_id' =>  '1',
        'workshop_category_id' =>  '1',
    );


    $this->assertEquals($expected, $result);

    $sql = "DELETE FROM workshop
    WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $id));

  }



}
