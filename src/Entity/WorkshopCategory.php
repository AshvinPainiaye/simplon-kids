<?php

namespace kids\Entity;

use kids\Config\Database;
use PDO;


class WorkshopCategory
{

    protected $_id;
    protected $_name;

    protected $connexion;

      public function __construct()
      {
        $db = new Database();
        $this->connexion =  $db->getConnexion();
      }


      public function fetchAll()
      {
        $connexion =  $this->connexion;

          $sql = "SELECT * FROM workshop_category";

        $stmt = $connexion->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();

        return $results;
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

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }



}
