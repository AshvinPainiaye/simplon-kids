<?php
namespace kids\Entity;

use kids\Config\Database;
use PDO;

class Workshop extends Database
{

  protected $_id;
  protected $_title;
  protected $_description;
  protected $_price;
  protected $_max_kids;
  protected $_image;
  protected $_visible;
  protected $_public_age_id;
  protected $_establishment_id;
  protected $_workshop_category_id;


  public function fetchAll($limit = null, $onlyVisible = true)
  {
    $connexion = $this->getConnexion();
    if ($limit != null) {
      $sql = "SELECT id FROM workshop ORDER BY id DESC LIMIT $limit";

      if ($onlyVisible == true) {
        $sql = "SELECT id FROM workshop WHERE visible = 1 ORDER BY id DESC LIMIT $limit";
      }

    } else {
      $sql = "SELECT id FROM workshop ORDER BY id DESC";

      if ($onlyVisible == true) {
        $sql = "SELECT id FROM workshop WHERE visible = 1 ORDER BY id DESC";
      }
    }

    $stmt = $connexion->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll();

    $return = array();
    foreach($results as $result)
    {
      $return[] = $this->find($result['id']);
    }
    return $return;
  }


  public function find($id)
  {
    $connexion =  $this->getConnexion();

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


    $jours = array(
      1 => 'Lundi',
      2 => 'Mardi',
      3 => 'Mercredi',
      4 =>  'Jeudi',
      5 => 'Vendredi',
      6 => 'Samedi',
      7 => 'Dimanche'
    );

    $mois = array(
      1 => 'jan',
      2 => 'fevrier',
      3 => 'mars',
      4 => 'avril',
      5 => 'mai',
      6 => 'juin',
      7 => 'juillet',
      8 => 'aout',
      9 => 'septembre',
      10 => 'octobre',
      11 => 'novembre',
      12 => 'decembre'
    );

    $day = date('N', strtotime($result['startAt']));

    $month = date('n', strtotime($result['startAt']));
    $result['time'] = $jours[$day] . ' ' . date('j', strtotime($result['startAt'])) . ' ' . $mois[$month] . ' ' . date('G', strtotime($result['startAt'])) . 'h - ' . date('G', strtotime($result['endAt'])) . 'h';
    return $result;

  }

  public function delete($id)
  {
    $connexion =  $this->getConnexion();

    $sql = "DELETE FROM workshop
    WHERE id = :id";

    $stmt = $connexion->prepare($sql);
    $stmt->execute(array(':id' => $id));
  }

  public function save()
  {
    $connexion =  $this->getConnexion();

    $title = $this->getTitle();
    $description = $this->getDescription();
    $price = $this->getPrice();
    $maxKids = $this->getMaxKids();
    $image = $this->getImage();
    $visible = $this->getVisible();
    $age = $this->getPublicAgeId();
    $establishment = $this->getEstablishmentId();
    $workshopCategory = $this->getWorkshopCategoryId();

    try {

      $sql = "INSERT INTO workshop (title, description, price, max_kids, image, visible, public_age_id, establishment_id, workshop_category_id) VALUE (:title, :description, :price, :max_kids, :image, :visible, :public_age_id, :establishment_id, :workshop_category_id)";

      $stmt = $connexion->prepare($sql);

      $stmt->bindParam(':title', $title);
      $stmt->bindParam(':description', $description);
      $stmt->bindParam(':price',$price);
      $stmt->bindParam(':max_kids', $maxKids);
      $stmt->bindParam(':image', $image);
      $stmt->bindParam(':visible', $visible);
      $stmt->bindParam(':public_age_id', $age);
      $stmt->bindParam(':establishment_id', $establishment);
      $stmt->bindParam(':workshop_category_id', $workshopCategory);
      $stmt->execute();

      $lastId =  $connexion->lastInsertId();
      $this->setId($lastId);

    } catch (Exception $e) {
      echo $e->getMessage();
    }

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

  public function getTitle()
  {
    return $this->_title;
  }

  public function setTitle($title)
  {
    $this->_title = $title;
    return $this;
  }

  public function getDescription()
  {
    return $this->_description;
  }

  public function setDescription($description)
  {
    $this->_description = $description;
    return $this;
  }

  public function getPrice()
  {
    return $this->_price;
  }

  public function setPrice($price)
  {
    $this->_price = $price;
    return $this;
  }

  public function getMaxKids()
  {
    return $this->_max_kids;
  }

  public function setMaxKids($maxKids)
  {
    $this->_max_kids = $maxKids;
    return $this;
  }

  public function getImage()
  {
    return $this->_image;
  }

  public function setImage($image)
  {
    $this->_image = $image;
    return $this;
  }

  public function getVisible()
  {
    return $this->_visible;
  }

  public function setVisible($visible)
  {
    $this->_visible = $visible;
    return $this;
  }

  public function getPublicAgeId()
  {
    return $this->_public_age_id;
  }

  public function setPublicAgeId($publicAgeId)
  {
    $this->_public_age_id = $publicAgeId;
    return $this;
  }

  public function getEstablishmentId()
  {
    return $this->_establishment_id;
  }

  public function setEstablishmentId($establishmentId)
  {
    $this->_establishment_id = $establishmentId;
    return $this;
  }

  public function getWorkshopCategoryId()
  {
    return $this->_workshop_category_id;
  }

  public function setWorkshopCategoryId($workshopCategoryId)
  {
    $this->_workshop_category_id = $workshopCategoryId;
    return $this;
  }



}
