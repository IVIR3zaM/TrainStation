<?php
namespace IVIR3zaM\TrainStation;

use Exception;

class Lines extends Iterator implements LinesInterface
{
    /**
     * @var array list of latest times in lines
     */
    protected $trainsLatestTimes = [];

    protected function getProperLine(TrainInterface $train) : int
    {
        foreach ($this->trainsLatestTimes as $timestamp => $lines) {
            if ($timestamp < $train->getArriveTime()->getTimestamp()) {
                return key($lines);
            }
        }
        $index = count($this->objects);
        $line = new Line();
        $this->objects[$index] = $line;
        return $index;
    }

    protected function changeLineLatestTime(int $lineIndex, int $lastTime, int $currentTime)
    {
        if (isset($this->trainsLatestTimes[$lastTime][$lineIndex])) {
            unset($this->trainsLatestTimes[$lastTime][$lineIndex]);
            if (empty($this->trainsLatestTimes[$lastTime])) {
                unset($this->trainsLatestTimes[$lastTime]);
            }
        }
        $this->trainsLatestTimes[$currentTime][$lineIndex] = true;
        ksort($this->trainsLatestTimes[$currentTime]);
    }

    public function addTrain(TrainInterface $train) : LinesInterface
    {
        $lineIndex = $this->getProperLine($train);
        $line = $this->getLineByIndex($lineIndex);
        if (!$line instanceof LineInterface) {
            throw new Exception('Invalid line Index');
        }
        $this->changeLineLatestTime($lineIndex, $line->getLatestLeaveTime()->getTimestamp(), $train->getLeaveTime()->getTimestamp());
        $line->addTrain($train);
        return $this;
    }

    public function getLineByIndex(int $index)
    {
        if (isset($this->objects[$index])) {
            return $this->objects[$index];
        }
    }

    public function reset()
    {
        $this->objects = [];
        $this->trainsLatestTimes = [];
    }
}