<?php
namespace IVIR3zaM\TrainStation;

use DateTimeInterface;

interface LineInterface extends \Countable, \Iterator
{
    public function addTrain(TrainInterface $train) : LineInterface;
    
    public function getTrainByIndex(int $index);

    public function getLatestLeaveTime() : DateTimeInterface;
}