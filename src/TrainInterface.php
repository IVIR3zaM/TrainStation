<?php
namespace IVIR3zaM\TrainStation;

use DateTimeInterface;

interface TrainInterface
{
    public function setArriveTime(DateTimeInterface $date) : TrainInterface;

    public function getArriveTime() : DateTimeInterface;

    public function setLeaveTime(DateTimeInterface $date) : TrainInterface;

    public function getLeaveTime() : DateTimeInterface;
}