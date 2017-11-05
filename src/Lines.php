<?php
namespace IVIR3zaM\TrainStation;

class Lines extends Iterator implements LinesInterface
{
    protected function getProperLine(TrainInterface $train) : LineInterface
    {
        foreach ($this->objects as $line) {
            if ($line->getLatestLeaveTime() < $train->getArriveTime()) {
                return $line;
            }
        }
        $line = new Line();
        $this->objects[] = $line;
        return $line;
    }

    public function addTrain(TrainInterface $train) : LinesInterface
    {
        $line = $this->getProperLine($train);
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
    }
}