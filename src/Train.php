<?php
namespace IVIR3zaM\TrainStation;

use DateTimeInterface;
use DateTime;

class Train implements TrainInterface
{
    /**
     * @var DateTimeInterface
     */
    protected $arriveDate;

    /**
     * @var DateTimeInterface
     */
    protected $leaveDate;

    public function __construct(DateTimeInterface $arriveDate = null, DateTimeInterface $leaveDate = null)
    {
        if (is_null($arriveDate)) {
            $arriveDate = new DateTime();
        }

        if (is_null($leaveDate)) {
            $leaveDate = new DateTime();
        }

        $this->setArriveTime($arriveDate);
        $this->setLeaveTime($leaveDate);
    }

    public function setArriveTime(DateTimeInterface $date) : TrainInterface
    {
        $this->arriveDate = $date;
        return $this;
    }

    public function getArriveTime() : DateTimeInterface
    {
        return $this->arriveDate;
    }

    public function setLeaveTime(DateTimeInterface $date) : TrainInterface
    {
        $this->leaveDate = $date;
        return $this;
    }

    public function getLeaveTime() : DateTimeInterface
    {
        return $this->leaveDate;
    }

    public function hasConflict(TrainInterface $train) : bool
    {
        if ($this->getArriveTime() >= $train->getArriveTime()
            && $this->getArriveTime() <= $train->getLeaveTime()) {
            return true;
        }
        if ($this->getLeaveTime() >= $train->getArriveTime()
            && $this->getLeaveTime() <= $train->getLeaveTime()) {
            return true;
        }
        if ($this->getArriveTime() < $train->getArriveTime()
            && $this->getLeaveTime() > $train->getLeaveTime()) {
            return true;
        }
        return false;
    }
}