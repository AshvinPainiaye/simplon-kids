<?php

namespace kids\Entity;

use kids\Config\Database;
use PDO;

class PublicAge
{

    protected $_id;
    protected $_start;
    protected $_end;


    protected $connexion;

      public function __construct()
      {
        $db = new Database();
        $this->connexion =  $db->getConnexion();
      }


      public function fetchAll()
      {
        $connexion =  $this->connexion;

          $sql = "SELECT * FROM public_age";

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

    public function getStart()
    {
        return $this->_start;
    }

    public function setStart($start)
    {
        $this->_start = $start;
        return $this;
    }

    public function getEnd()
    {
        return $this->_end;
    }

    public function setEnd($end)
    {
        $this->_end = $end;
        return $this;
    }



}
