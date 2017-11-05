<?php
namespace IVIR3zaM\TrainStation\Tests;

use IVIR3zaM\TrainStation\Line;
use IVIR3zaM\TrainStation\LineInterface;
use DateTime;
use Exception;
use IVIR3zaM\TrainStation\Train;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    /**
     * @var LineInterface
     */
    private $line;

    public function setUp()
    {
        $this->line = new Line();
    }

    public function testAddGetTrain()
    {
        $train = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $this->line->addTrain($train);
        $this->assertCount(1, $this->line);
        $this->assertSame($train->getLeaveTime(), $this->line->getLatestLeaveTime());
        $this->assertSame($train, $this->line->getTrainByIndex(0));
        $this->assertNull($this->line->getTrainByIndex(1));
    }

    /**
     * @expectedException Exception
     */
    public function testTrainConflicts()
    {
        $train = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $this->line->addTrain($train);
        $this->line->addTrain($train);
    }

    public function testIterator()
    {
        $train1 = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $train2 = new Train(new DateTime('+1 Hour, +1 Minute'), new DateTime('+2 Hour'));
        $this->line->addTrain($train1);
        $this->line->addTrain($train2);

        $this->assertCount(2, $this->line);
        $this->assertSame(0, $this->line->key());
        $this->assertTrue($this->line->valid());
        $this->assertSame($train1, $this->line->current());

        $this->line->next();
        $this->assertSame(1, $this->line->key());
        $this->assertTrue($this->line->valid());
        $this->assertSame($train2, $this->line->current());

        $this->line->next();
        $this->assertSame(2, $this->line->key());
        $this->assertFalse($this->line->valid());

        $this->line->rewind();
        $this->assertSame(0, $this->line->key());
        $this->assertTrue($this->line->valid());
    }
}