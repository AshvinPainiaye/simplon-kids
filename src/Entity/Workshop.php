<?php
namespace kids\Entity;

use kids\Config\Database;
use PDO;

class Workshop
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

    protected $connexion;

      public function __construct()
      {
        $db = new Database();
        $this->connexion =  $db->getConnexion();
      }


      public function fetchAll($limit = null)
      {
        $connexion =  $this->connexion;

        if ($limit != null) {
          $sql = "SELECT id FROM workshop WHERE visible = 1 ORDER BY id DESC LIMIT $limit";
        } else {
          $sql = "SELECT id FROM workshop WHERE visible = 1 ORDER BY id DESC";
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
          $connexion =  $this->connexion;

          $sql = "SELECT *
          FROM workshop as w
          JOIN public_age a
          ON w.public_age_id = a.id
          JOIN establishment e
          ON w.establishment_id = e.id
          JOIN workshop_category c
          ON w.workshop_category_id = c.id
          WHERE w.id = :id";

          $stmt = $connexion->prepare($sql);
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result;
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
