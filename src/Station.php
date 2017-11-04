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

    public function calculateLines() : array
    {
        $lines = [];

        foreach ($this->trains as $train) {
            $inserted = false;
            foreach ($lines as &$line) {
                $accepted = true;
                foreach ($line as $scheduledTrain) {
                    if ($train->hasConflict($scheduledTrain)) {
                        $accepted = false;
                        break;
                    }
                }
                if ($accepted) {
                    $line[] = $train;
                    $inserted = true;
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