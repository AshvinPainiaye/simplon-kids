<?php


namespace Kids\Entity;

use Kids\Config\Database;
use PDO;


class KidHasParent extends Database
{

    protected $_kid_id;
    protected $_parent_id;

    public function fetchAll()
    {
      $connexion = $this->getConnexion();
        $sql = "SELECT * FROM kid_has_parent";

      $stmt = $connexion->prepare($sql);
      $stmt->execute();

      $results = $stmt->fetchAll();

      return $results;
    }

    public function save()
    {
      $connexion =  $this->getConnexion();

      $kidId = $this->getKidId();
      $parentId = $this->getParentId();

      try {

        $sql = "INSERT INTO kid_has_parent (kid_id, parent_id) VALUE (:kid_id, :parent_id)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':kid_id', $kidId);
        $stmt->bindParam(':parent_id', $parentId);
        $stmt->execute();

      } catch (Exception $e) {
        echo $e->getMessage();
      }

    }


    /**
     * GETTERS / SETTERS
     */
    public function getKidId()
    {
        return $this->_kid_id;
    }

    public function setKidId($kidId)
    {
        $this->_kid_id = $kidId;
        return $this;
    }

    public function getParentId()
    {
        return $this->_parent_id;
    }

    public function setParentId($parentId)
    {
        $this->_parent_id = $parentId;
        return $this;
    }



}
