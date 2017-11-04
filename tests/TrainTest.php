<?php
namespace IVIR3zaM\TrainStation\Tests;

use IVIR3zaM\TrainStation\Train;
use IVIR3zaM\TrainStation\TrainInterface;
use DateTime;
use PHPUnit\Framework\TestCase;

class TrainTest extends TestCase
{
    /**
     * @var TrainInterface
     */
    private $train;

    public function setUp()
    {
        $this->train = new Train();
    }

    public function testArriveAndLeaveDates()
    {
        $arrive = new DateTime('+1 Hour');
        $this->train->setArriveTime($arrive);

        $this->assertSame($arrive->getTimestamp(), $this->train->getArriveTime()->getTimestamp());

        $leave = new DateTime('+2 Hour');
        $this->train->setLeaveTime($leave);

        $this->assertSame($leave->getTimestamp(), $this->train->getLeaveTime()->getTimestamp());
    }
}