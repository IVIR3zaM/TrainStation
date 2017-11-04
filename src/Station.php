<?php
namespace IVIR3zaM\TrainStation;

class Station implements StationInterface
{
    /**
     * @var TrainInterface[]
     */
    protected $trains = [];

    public function addTrain(TrainInterface $train) : StationInterface
    {
        $this->trains[spl_object_hash($train)] = $train;
        return $this;
    }

    public function removeTrain(TrainInterface $train) : StationInterface
    {
        $index = spl_object_hash($train);
        if (isset($this->trains[$index])) {
            unset($this->trains[$index]);
        }
        return $this;
    }

    public function countTrains() : int
    {
        return count($this->trains);
    }

    protected function canInsertTrain(array $line, TrainInterface $train) : bool
    {
        foreach ($line as $scheduledTrain) {
            if ($train->hasConflict($scheduledTrain)) {
                return false;
            }
        }
        return true;
    }

    protected function sortTrains() : array
    {
        uasort($this->trains, function (TrainInterface $train1, TrainInterface $train2) {
            if ($train1->getArriveTime()->getTimestamp() == $train2->getArriveTime()->getTimestamp()) {
                return 0;
            }
            return $train1->getArriveTime()->getTimestamp() < $train2->getArriveTime()->getTimestamp() ? -1 : 1;
        });
        return $this->trains;
    }

    protected function calculateProperLine(array $lines, TrainInterface $train) : int
    {
        $lineIndex = null;
        foreach ($lines as $index => $line) {
            if ($this->canInsertTrain($line, $train)) {
                $lineIndex = $index;
                break;
            }
        }
        if ($lineIndex === null) {
            $lineIndex = count($lines);
        }
        return $lineIndex;
    }

    public function calculateLines() : array
    {
        $lines = [];
        $trains = $this->sortTrains();
        while (($train = array_shift($trains))) {
            $lineIndex = $this->calculateProperLine($lines, $train);
            $lines[$lineIndex][] = $train;
        }
        return $lines;
    }
}