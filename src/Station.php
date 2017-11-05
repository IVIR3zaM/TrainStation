<?php
namespace IVIR3zaM\TrainStation;

class Station extends Iterator implements StationInterface
{
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
        $this->objects[] = $train;
        return $this;
    }

    public function removeTrain(TrainInterface $train) : StationInterface
    {
        foreach ($this->objects as $index => $value) {
            if ($value === $train) {
                $this->removeTrainByIndex($index);
                break;
            }
        }
        return $this;
    }

    public function removeTrainByIndex(int $index) : StationInterface
    {
        if (isset($this->objects[$index])) {
            unset($this->objects[$index]);
        }
        return $this;
    }

    protected function sortTrains() : array
    {
        usort($this->objects, function (TrainInterface $train1, TrainInterface $train2) {
            if ($train1->getArriveTime()->getTimestamp() == $train2->getArriveTime()->getTimestamp()) {
                return 0;
            }
            return $train1->getArriveTime()->getTimestamp() < $train2->getArriveTime()->getTimestamp() ? -1 : 1;
        });
        return $this->objects;
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