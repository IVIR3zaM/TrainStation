<?php
namespace IVIR3zaM\TrainStation\Tests;

use IVIR3zaM\TrainStation\Station;
use IVIR3zaM\TrainStation\StationInterface;
use IVIR3zaM\TrainStation\Train;
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
}