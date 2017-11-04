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

    public function testHaveConflict()
    {
        $this->train->setArriveTime(new DateTime('+1 Hour'));
        $this->train->setLeaveTime(new DateTime('+2 Hour'));

        $train = new Train(new DateTime('+2 Hour, +1 Minute'), new DateTime('+3 Hour'));
        $this->assertFalse($this->train->hasConflict($train));

        $train->setArriveTime($this->train->getLeaveTime());
        $this->assertTrue($this->train->hasConflict($train));

        $train->setArriveTime(new DateTime('now'));
        $this->assertTrue($this->train->hasConflict($train));

        $train->setLeaveTime(new DateTime('+1 Hour, -1 Second'));
        $this->assertFalse($this->train->hasConflict($train));

        $train->setArriveTime(new DateTime('+1 Hour, +10 Minute'));
        $train->setLeaveTime(new DateTime('+1 Hour, +30 Minute'));
        $this->assertTrue($this->train->hasConflict($train));
    }
}