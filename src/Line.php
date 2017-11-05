<?php
namespace IVIR3zaM\TrainStation;

use DateTimeInterface;
use DateTime;

class Line extends Iterator implements LineInterface
{

    /**
     * @var DateTimeInterface
     */
    protected $latestLeaveTime;

    public function __construct()
    {
        $this->setLatestLeaveTime(new DateTime('1970-01-01 00:00:00'));
    }

    public function addTrain(TrainInterface $train) : LineInterface
    {
        $this->objects[] = $train;
        if ($train->getLeaveTime() > $this->getLatestLeaveTime()) {
            $this->setLatestLeaveTime($train->getLeaveTime());
        }
        return $this;
    }

    public function getLatestLeaveTime() : DateTimeInterface
    {
        return $this->latestLeaveTime;
    }

    protected function setLatestLeaveTime(DateTimeInterface $date) : LineInterface
    {
        $this->latestLeaveTime = $date;
        return $this;
    }
}