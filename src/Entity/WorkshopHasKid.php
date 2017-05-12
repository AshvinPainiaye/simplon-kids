<?php


namespace kids\Entity;

use kids\Config\Database;
use PDO;


class WorkshopHasKid extends Database
{

    protected $_workshop_id;
    protected $_kid_id;
    protected $_has_participated;
    protected $_validated;

    public function fetchAll()
    {
      $connexion =  $this->getConnexion();

        $sql = "SELECT *, k.id as kid_id, k.firstname as kid_firstname, k.lastname as kid_lastname, p.firstname as parent_firstname, p.lastname as parent_lastname
        FROM workshop_has_kid as whk
        JOIN workshop w
        ON whk.workshop_id = w.id
        JOIN kid k
        ON whk.kid_id = k.id
        JOIN kid_has_parent khp
        ON khp.kid_id = k.id
        JOIN parent p
        ON khp.parent_id = p.id
        WHERE whk.validated IS NULL";

      $stmt = $connexion->prepare($sql);
      $stmt->execute();

      $results = $stmt->fetchAll();

      return $results;
    }



    public function find($workshopId, $kidId)
    {
      $connexion =  $this->getConnexion();

      $sql = "SELECT *
      FROM workshop_has_kid
      WHERE workshop_id = :workshop_id
      AND kid_id = :kid_id";

      $stmt = $connexion->prepare($sql);
      $stmt->execute(array(':workshop_id' => $workshopId,':kid_id' => $kidId));
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      return $result;
    }



    public function save()
    {
      $connexion =  $this->getConnexion();

      $workshopId = $this->getWorkshopId();
      $kidId = $this->getKidId();
      $validated = NULL;

      try {

        $sql = "INSERT INTO workshop_has_kid (workshop_id, kid_id, validated) VALUE (:workshop_id, :kid_id, :validated)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindParam(':workshop_id', $workshopId);
        $stmt->bindParam(':kid_id', $kidId);
        $stmt->bindParam(':validated', $validated);
        $stmt->execute();

      } catch (Exception $e) {
        echo $e->getMessage();
      }

    }

    public function edit($validated, $workshop, $kid)
    {
      $connexion =  $this->getConnexion();

      $workshopId = $this->getWorkshopId();
      $kidId = $this->getKidId();

      try {

        $sql = "UPDATE `workshop_has_kid` SET `validated` = $validated WHERE `workshop_has_kid`.`workshop_id` = $workshop AND `workshop_has_kid`.`kid_id` = $kid";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();

      } catch (Exception $e) {
        echo $e->getMessage();
      }

    }

    /**
     * GETTERS / SETTERS
     */
    public function getWorkshopId()
    {
        return $this->_workshop_id;
    }

    public function setWorkshopId($workshopId)
    {
        $this->_workshop_id = $workshopId;
        return $this;
    }

    public function getKidId()
    {
        return $this->_kid_id;
    }

    public function setKidId($kidId)
    {
        $this->_kid_id = $kidId;
        return $this;
    }

    public function getHasParticipated()
    {
        return $this->_has_participated;
    }

    public function setHasParticipated($hasParticipated)
    {
        $this->_has_participated = $hasParticipated;
        return $this;
    }

    public function getValidated()
    {
        return $this->_validated;
    }

    public function setValidated($validated)
    {
        $this->_validated = $validated;
        return $this;
    }



}
