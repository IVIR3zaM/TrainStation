<?php
namespace IVIR3zaM\TrainStation\Tests;

use IVIR3zaM\TrainStation\Iterator;

class IteratorFake extends Iterator
{
    public function addObject($object)
    {
        $this->objects[] = $object;
    }
}