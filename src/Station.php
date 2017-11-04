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
        $this->trains[] = $train;
        return $this;
    }
    public function countTrains() : int
    {
        return count($this->trains);
    }
}