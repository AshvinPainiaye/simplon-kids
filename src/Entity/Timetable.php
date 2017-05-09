<?php

namespace kids\Entity;

class App_Model_Timetable
{

    protected $_id;
    protected $_startAt;
    protected $_endAt;
    protected $_enable;
    protected $_workshop_id;



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

    public function getStartAt()
    {
        return $this->_startAt;
    }

    public function setStartAt($startAt)
    {
        $this->_startAt = $startAt;
        return $this;
    }

    public function getEndAt()
    {
        return $this->_endAt;
    }

    public function setEndAt($endAt)
    {
        $this->_endAt = $endAt;
        return $this;
    }

    public function getEnable()
    {
        return $this->_enable;
    }

    public function setEnable($enable)
    {
        $this->_enable = $enable;
        return $this;
    }

    public function getWorkshopId()
    {
        return $this->_workshop_id;
    }

    public function setWorkshopId($workshopId)
    {
        $this->_workshop_id = $workshopId;
        return $this;
    }



}
