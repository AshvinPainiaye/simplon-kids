<?php

namespace Kids\Entity;

use Kids\Config\Database;
use PDO;


class WorkshopCategory extends Database
{

    protected $_id;
    protected $_name;


      public function fetchAll()
      {
        $connexion =  $this->getConnexion();

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
