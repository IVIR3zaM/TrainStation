<?php
namespace IVIR3zaM\TrainStation;

use DateTimeInterface;
use DateTime;
use Exception;

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

    /**
     * @param TrainInterface $train
     * @throws Exception
     */
    protected function checkTrainConflict(TrainInterface $train)
    {
        if ($train->getArriveTime() <= $this->getLatestLeaveTime()) {
            throw new Exception('Train can not added to this line');
        }
    }

    protected function checkLineLatestLeaveTime(TrainInterface $train)
    {
        if ($train->getLeaveTime() > $this->getLatestLeaveTime()) {
            $this->setLatestLeaveTime($train->getLeaveTime());
        }
    }

    /**
     * @param TrainInterface $train
     * @return LineInterface
     * @throws Exception
     */
    public function addTrain(TrainInterface $train) : LineInterface
    {
        $this->checkTrainConflict($train);
        $this->checkLineLatestLeaveTime($train);
        $this->objects[] = $train;
        return $this;
    }

    public function getTrainByIndex(int $index)
    {
        if (isset($this->objects[$index])) {
            return $this->objects[$index];
        }
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