<?php

namespace Tests\app;

use PDO;
use Kids\Entity\Workshop;
use Kids\Entity\Address;
use Kids\Entity\Kid;
use Kids\Entity\KidHasParent;
use Kids\Entity\ParentOfKid;
use Kids\Entity\WorkshopHasKid;

class WorkshopTest extends DatabaseTest
{

  /**
  * Recupere la liste des ateliers
  *
  */
  function testFetchAllWorkshop() {

    $workshop = new Workshop();
    $actual = $workshop->fetchAll();

    $expected = array(
      array(
        "id"=>  "3",
        "title"=>  "Code academy",
        "description"=>  "code academy !!!!",
        "price"=>  "69.00",
        "max_kids"=> "30",
        "image"=> "14944840972.jpg",
        "visible"=>  "1",
        "public_age_id"=> "4",
        "establishment_id"=>  "1",
        "workshop_category_id"=>  "4",
        "start"=>  "4",
        "end"=>  "9",
        "name"=> "Logique",
        "address_id"=>  "2",
        "startAt"=> "2017-06-07 08:00:00",
        "endAt"=>  "2017-06-07 18:00:00",
        "enable"=> NULL,
        "workshop_id"=> "3"
      ),
      array(
        "id"=>  "2",
        "title"=> "CSS",
        "description"=> "Ateliers css",
        "price"=> "20.00",
        "max_kids"=> "15",
        "image"=>  "14944840290.jpg",
        "visible"=> "1",
        "public_age_id"=> "2",
        "establishment_id"=> "1",
        "workshop_category_id"=>  "3",
        "start"=>  "10",
        "end"=> "18",
        "name"=> "Detente",
        "address_id"=> "2",
        "startAt"=>  "2017-05-21 11:30:00",
        "endAt"=>  "2017-05-21 15:30:00",
        "enable"=> NULL,
        "workshop_id"=> "2"
      ),
      array(
        "id"=>  "1",
        "title"=> "HTML",
        "description"=> "Debuter en html",
        "price"=> "10.00",
        "max_kids"=> "18",
        "image"=>  "1.jpg",
        "visible"=>  "1",
        "public_age_id"=>  "1",
        "establishment_id"=>  "1",
        "workshop_category_id"=> "1",
        "start"=>  "1",
        "end"=>  "18",
        "name"=> "ART",
        "address_id"=>  "2",
        "startAt"=>  "2017-05-09 08:30:00",
        "endAt"=>  "2017-05-09 16:30:00",
        "enable"=>  "1",
        "workshop_id"=> "1"
      )

    );

    $this->assertEquals($expected, $actual);
  }



  /**
  * Recupere un atelier
  *
  */
  function testFindWorkshop() {

    $workshop = new Workshop();
    $actual = $workshop->find(1);

    $expected = array(
      "id"=> "1",
      "title"=> "HTML",
      "description"=>  "Debuter en html",
      "price"=> "10.00",
      "max_kids"=>  "18",
      "image"=>  "1.jpg",
      "visible"=>  "1",
      "public_age_id"=>  "1",
      "establishment_id"=>  "1",
      "workshop_category_id"=>  "1",
      "start"=>  "1",
      "end"=>  "18",
      "name"=>  "ART",
      "address_id"=>  "2",
      "startAt"=>  "2017-05-09 08:30:00",
      "endAt"=> "2017-05-09 16:30:00",
      "enable"=>  "1",
      "workshop_id"=>  "1"
    );
    $this->assertEquals($expected, $actual);
  }



  /**
  * Créer un atelier
  *
  */
  function testNewWorkshop() {

    $workshop = new Workshop();

    $expected = count($workshop->fetchAll()) + 1;

    $workshop
    ->setTitle('title')
    ->setDescription('description')
    ->setPrice('11')
    ->setMaxKids('12')
    ->setImage('1.jpg')
    ->setVisible(1)
    ->setPublicAgeId(1)
    ->setEstablishmentId(1)
    ->setWorkshopCategoryId(1);
    $workshop->save();

    $actual = count($workshop->fetchAll());
    $this->assertEquals($expected, $actual);

    $workshop->delete($workshop->getId());

  }



  /**
  * Supprime un atelier
  *
  */
  function testDeleteWorkshop() {
    $workshop = new Workshop();

    $workshop
    ->setTitle('title')
    ->setDescription('description')
    ->setPrice('11')
    ->setMaxKids('12')
    ->setImage('1.jpg')
    ->setVisible(1)
    ->setPublicAgeId(1)
    ->setEstablishmentId(1)
    ->setWorkshopCategoryId(1);
    $workshop->save();

    $expected = count($workshop->fetchAll()) - 1;
    $workshop->delete($workshop->getId());
    $actual = count($workshop->fetchAll());
    $this->assertEquals($expected, $actual);
  }



  /**
  * Inscription a un ateliers
  *
  */
  function testRegisterWorkshop() {
    $expected = array();
    $actual = array();

    $address = new Address();
    $expected['address'] = count($address->fetchAll()) + 1;
    $address->setAddress('15 rue des saphirs')
    ->setComplement('')
    ->setCity('Sainte-Suzanne')
    ->setZipcode('97441')
    ->save();
    $actual['address'] = count($address->fetchAll());


    $parent = new ParentOfKid();
    $expected['parent'] = count($parent->fetchAll()) + 1;
    $parent->setFirstname('Ashvin')
    ->setLastname('Painiaye')
    ->setEmail('contact@ashvinpainiaye.com')
    ->setAddressId($address->getId())
    ->setPhone('0692123456')
    ->save();
    $actual['parent'] = count($parent->fetchAll());

    $enfant = new Kid();
    $expected['kid'] = count($enfant->fetchAll()) + 1;
    $enfant->setFirstname('John')
    ->setLastname('Doe')
    ->setBirthday('1999-01-03')
    ->setClassroom('')
    ->save();
    $actual['kid'] = count($enfant->fetchAll());

    $WorkshopHasKid = new WorkshopHasKid();
    $expected['workshop_has_kid'] = count($WorkshopHasKid->fetchAllTable()) + 1;
    $WorkshopHasKid->setWorkshopId(1)
    ->setKidId($enfant->getId())
    ->save();
    $actual['workshop_has_kid'] = count($WorkshopHasKid->fetchAllTable());

    $kidHasParent = new KidHasParent();
    $expected['kid_has_parent'] = count($kidHasParent->fetchAll()) + 1;
    $kidHasParent->setKidId($enfant->getId())
    ->setParentId($parent->getId())
    ->save();
    $actual['kid_has_parent'] = count($kidHasParent->fetchAll());

    $this->assertEquals($expected, $actual);
    

    $connexion = $this->getConnection();
    $sql = "DELETE FROM kid_has_parent WHERE parent_id = :parent_id AND kid_id = :kid_id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':parent_id' => $parent->getId(), ':kid_id' => $enfant->getId()));

    $sql = "DELETE FROM workshop_has_kid WHERE workshop_id = 1 AND kid_id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $enfant->getId()));

    $sql = "DELETE FROM kid WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $enfant->getId()));

    $sql = "DELETE FROM parent WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $parent->getId()));

    $sql = "DELETE FROM address WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $address->getId()));

  }


}
