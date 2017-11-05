<?php
namespace IVIR3zaM\TrainStation;

use DateTimeInterface;
use DateTime;

class Line implements LineInterface
{
    /**
     * @var TrainInterface[]
     */
    protected $trains = [];

    /**
     * @var DateTimeInterface
     */
    protected $latestLeaveTime;


    /**
     * @var int
     */
    protected $position = 0;

    public function __construct()
    {
        $this->setLatestLeaveTime(new DateTime('1970-01-01 00:00:00'));
    }

    public function addTrain(TrainInterface $train) : LineInterface
    {
        $this->trains[] = $train;
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

    public function current()
    {
        if (isset($this->trains[$this->position])) {
            return $this->trains[$this->position];
        }
    }

    public function key() : int
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid() : bool
    {
        return isset($this->trains[$this->position]);
    }

    public function count() : int
    {
        return count($this->trains);
    }
}