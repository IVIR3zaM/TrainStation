<?php
namespace IVIR3zaM\TrainStation;

interface LinesInterface extends \Countable, \Iterator
{
    public function addTrain(TrainInterface $train) : LinesInterface;

    public function getLineByIndex(int $index);

    public function reset();
}