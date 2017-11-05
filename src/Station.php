<?php
namespace IVIR3zaM\TrainStation;

class Station implements StationInterface
{
    /**
     * @var TrainInterface[]
     */
    protected $trains = [];

    /**
     * @var LinesInterface
     */
    protected $lines;
    
    public function __construct(LinesInterface $lines)
    {
        $this->setLines($lines);
    }

    public function setLines(LinesInterface $lines) : StationInterface
    {
        $this->lines = $lines;
        return $this;
    }

    public function getLines() : LinesInterface
    {
        return $this->lines;
    }

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

    public function calculateLines() : LinesInterface
    {
        $this->getLines()->reset();
        $trains = $this->sortTrains();
        foreach ($trains as $train) {
            $this->getLines()->addTrain($train);
        }
        return $this->getLines();
    }
}