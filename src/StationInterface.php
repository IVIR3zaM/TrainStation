<?php
namespace IVIR3zaM\TrainStation;

interface StationInterface extends \Countable, \Iterator
{
    public function addTrain(TrainInterface $train) : StationInterface;

    public function removeTrain(TrainInterface $train) : StationInterface;

    public function removeTrainByIndex(int $index) : StationInterface;

    public function setLines(LinesInterface $lines) : StationInterface;

    public function getLines() : LinesInterface;

    public function calculateLines() : LinesInterface;
}