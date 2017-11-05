<?php
namespace IVIR3zaM\TrainStation\Tests;

use IVIR3zaM\TrainStation\Lines;
use IVIR3zaM\TrainStation\TrainInterface;

class LinesFake extends Lines
{
    protected function getProperLine(TrainInterface $train) : int
    {
        return count($this->objects);
    }
}