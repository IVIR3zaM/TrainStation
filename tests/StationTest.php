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
    }
}