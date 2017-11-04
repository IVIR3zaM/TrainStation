<?php
namespace IVIR3zaM\TrainStation\Tests;

use IVIR3zaM\TrainStation\Station;
use IVIR3zaM\TrainStation\StationInterface;
use IVIR3zaM\TrainStation\Train;
use DateTime;
use PHPUnit\Framework\TestCase;

class StationTest extends TestCase
{
    /**
     * @var StationInterface
     */
    private $station;

    public function setUp()
    {
        $this->station = new Station();
    }
    
    public function testAddRemoveTrain()
    {
        $train = new Train();

        $this->station->addTrain($train);
        $this->assertSame(1, $this->station->countTrains());

        $this->station->removeTrain($train);
        $this->assertSame(0, $this->station->countTrains());
    }

    public function testCalculateLines()
    {
        $train1 = new Train(new DateTime('+1 Hour'), new DateTime('+2 Hour'));
        $train2 = new Train(new DateTime('+2 Hour, +1 Minute'), new DateTime('+3 Hour'));

        $this->station->addTrain($train1);
        $this->station->addTrain($train2);

        $this->assertSame(2, $this->station->countTrains());
        $this->assertCount(1, $this->station->calculateLines());

        $train3 = new Train(new DateTime('now'), new DateTime('+1 Hour'));

        $this->station->addTrain($train3);
        $this->assertSame(3, $this->station->countTrains());
        $this->assertCount(2, $this->station->calculateLines());

        $train3->setLeaveTime(new DateTime('+1 Hour, -1 Second'));
        $this->assertCount(1, $this->station->calculateLines());
    }

    public function testComplexCalculateLines()
    {
        $train1 = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $train2 = new Train(new DateTime('+1 Hour, +30 Minute'), new DateTime('+3 Hour'));
        $train3 = new Train(new DateTime('+30 Minute'), new DateTime('+1 Hour, +29 Minute'));
        $train4 = new Train(new DateTime('+1 Hour, +1 Minute'), new DateTime('+2 Hour'));

        $this->station->addTrain($train1);
        $this->station->addTrain($train2);
        $this->station->addTrain($train3);
        $this->station->addTrain($train4);

        $this->assertSame(4, $this->station->countTrains());
        $this->assertCount(2, $this->station->calculateLines());
    }

    public function testMoreComplexCalculateLines()
    {
        $train1 = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $train2 = new Train(new DateTime('+2 Hour'), new DateTime('+3 Hour'));
        $train3 = new Train(new DateTime('+1 Hour, +1 Minute'), new DateTime('+3 Hour'));
        $train4 = new Train(new DateTime('+1 Hour, +5 Minute'), new DateTime('+1 Hour, +59 Minute'));
        $train5 = new Train(new DateTime('now'), new DateTime('+1 Hour'));

        $this->station->addTrain($train1);
        $this->station->addTrain($train2);
        $this->station->addTrain($train3);
        $this->station->addTrain($train4);
        $this->station->addTrain($train5);

        $this->assertSame(5, $this->station->countTrains());
        $this->assertCount(2, $this->station->calculateLines());
    }
}