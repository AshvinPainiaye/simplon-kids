<?php

namespace Kids\Entity;

use Kids\Config\Database;
use PDO;

class PublicAge extends Database
{

    protected $_id;
    protected $_start;
    protected $_end;


      public function fetchAll()
      {
        $connexion =  $this->getConnexion();

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
