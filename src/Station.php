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

    protected function canInsertTrain(array $line, TrainInterface $train) : bool {
        foreach ($line as $scheduledTrain) {
            if ($train->hasConflict($scheduledTrain)) {
                return false;
            }
        }
        return true;
    }

    public function calculateLines() : array
    {
        $lines = [];

        foreach ($this->trains as $train) {
            $inserted = false;
            foreach ($lines as &$line) {
                $inserted = $this->canInsertTrain($line, $train);
                if ($inserted) {
                    $line[] = $train;
                    break;
                }
            }
            if (!$inserted) {
                $lines[] = [$train];
            }
        }

        return $lines;
    }
}