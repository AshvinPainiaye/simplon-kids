<?php


namespace kids\Entity;

use kids\Config\Database;
use PDO;


class KidHasParent
{

    protected $_kid_id;
    protected $_parent_id;

    protected $connexion;

    public function __construct()
    {
      $db = new Database();
      $this->connexion =  $db->getConnexion();
    }

    public function save()
    {
      $connexion =  $this->connexion;

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
