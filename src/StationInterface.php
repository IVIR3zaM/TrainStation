<?php
namespace IVIR3zaM\TrainStation;

interface StationInterface
{
    public function addTrain(TrainInterface $train) : StationInterface;

    public function removeTrain(TrainInterface $train) : StationInterface;

    public function countTrains() : int;

    public function setLines(LinesInterface $lines) : StationInterface;

    public function getLines() : LinesInterface;

    public function calculateLines() : LinesInterface;
}