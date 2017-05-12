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



  /**
  * Supprime un atelier
  *
  */
  function testDeleteWorkshop() {

    $connexion =  $this->getConnection();
    $sql = "INSERT INTO workshop (title, description, price, max_kids, image, visible, public_age_id, establishment_id, workshop_category_id) VALUES ('Code academy', 'Code academy !!!', 14, 12, '1.jpg', 1, 1, 1, 1)";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    $id = $connexion->lastInsertId();

    $sql = "DELETE FROM workshop
    WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $id));

    $sql = "SELECT * FROM workshop WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $id));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertFalse($result);

  }



  /**
  * Inscription a un ateliers
  *
  */
  function testRegisterWorkshop() {

    $connexion =  $this->getConnection();

    // ADDRESS
    $sql = "INSERT INTO address (address, complement, city, zipcode) VALUE ('15 rue des saphirs', 'Quartier Francais', 'Sainte-Suzanne', '97441')";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $addressId = $connexion->lastInsertId();

    $sql = "SELECT * FROM address WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $addressId));

    $address = $stmt->fetch(PDO::FETCH_ASSOC);


    // PARENT
    $sql = "INSERT INTO parent (firstname, lastname, email, address_id, phone) VALUE ('Ashvin', 'PAINIAYE', 'contact@ashvinpainiaye.com', $addressId, '+262692123456')";

    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $parentId = $connexion->lastInsertId();


    $sql = "SELECT * FROM parent WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $parentId));

    $parent = $stmt->fetch(PDO::FETCH_ASSOC);


    // KID
    $sql = "INSERT INTO kid (firstname, lastname, birthday, classroom) VALUE ('Joyce', 'PAINIAYE', '2006-02-05', 'CM2')";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $kidId = $connexion->lastInsertId();

    $sql = "SELECT * FROM kid WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $kidId));
    $kid = $stmt->fetch(PDO::FETCH_ASSOC);


    // WORKSHOP HAS KID
    $sql = "INSERT INTO workshop_has_kid (workshop_id, kid_id, validated) VALUE (1, $kidId, NULL)";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    $sql = "SELECT * FROM workshop_has_kid WHERE workshop_id = 1 AND kid_id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $kidId));
    $whk = $stmt->fetch(PDO::FETCH_ASSOC);



    // KID HAS WORKSHOP
    $sql = "INSERT INTO kid_has_parent (kid_id, parent_id) VALUE ($kidId, $parentId)";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    $sql = "SELECT * FROM kid_has_parent WHERE parent_id = :parent_id AND kid_id = :kid_id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':parent_id' => $parentId, ':kid_id' => $kidId));
    $khp = $stmt->fetch(PDO::FETCH_ASSOC);


    $expected = array(
      array(
        "id"=> $addressId,
        "address"=> "15 rue des saphirs",
        "complement"=> "Quartier Francais",
        "city"=>  "Sainte-Suzanne",
        "zipcode"=> "97441"
      ),
      array(
        "id"=> $parentId,
        "firstname"=>  "Ashvin",
        "lastname"=> "PAINIAYE",
        "email"=> "contact@ashvinpainiaye.com",
        "address_id"=> $addressId,
        "phone"=>  "+262692123456"
      ),
      array(
        "id"=> $kidId,
        "firstname"=> "Joyce",
        "lastname"=>  "PAINIAYE",
        "birthday"=>  "2006-02-05",
        "classroom"=>  "CM2"
      ),
      array(
        "workshop_id"=> "1",
        "kid_id"=> $kidId,
        "has_participated"=> NULL,
        "validated"=> NULL
      ),
      array(
        "kid_id"=> $kidId,
        "parent_id"=> $parentId
      )

    );


    $results = array($address,  $parent, $kid, $whk, $khp);
    $this->assertEquals($expected, $results);


    $sql = "DELETE FROM kid_has_parent WHERE parent_id = :parent_id AND kid_id = :kid_id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':parent_id' => $parentId, ':kid_id' => $kidId));

    $sql = "DELETE FROM workshop_has_kid WHERE workshop_id = 1 AND kid_id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $kidId));

    $sql = "DELETE FROM kid WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $kidId));

    $sql = "DELETE FROM parent WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $parentId));

    $sql = "DELETE FROM address WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $addressId));

  }


}
