<?php
namespace IVIR3zaM\TrainStation;

interface StationInterface
{
    public function addTrain(TrainInterface $train) : StationInterface;
    public function countTrains() : int;
}