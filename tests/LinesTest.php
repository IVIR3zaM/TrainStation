<?php
namespace IVIR3zaM\TrainStation\Tests;

use IVIR3zaM\TrainStation\LineInterface;
use IVIR3zaM\TrainStation\Train;
use IVIR3zaM\TrainStation\Lines;
use IVIR3zaM\TrainStation\LinesInterface;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class LinesTest extends TestCase
{
    /**
     * @var LinesInterface
     */
    private $lines;

    public function setUp()
    {
        $this->lines = new Lines();
    }

    public function testAddAndResetTrain()
    {
        $train = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $this->lines->addTrain($train);
        $this->assertCount(1, $this->lines);

        $this->lines->reset();
        $this->assertCount(0, $this->lines);
    }

    public function testGetLineByIndex()
    {
        $this->assertNull($this->lines->getLineByIndex(0));
        $train = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $this->lines->addTrain($train);
        $this->assertInstanceOf(LineInterface::class, $this->lines->getLineByIndex(0));
    }

    public function testFunctionality()
    {
        $train1 = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $train2 = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $train3 = new Train(new DateTime('+1 Hour, +1 Minute'), new DateTime('+3 Hour'));
        $train4 = new Train(new DateTime('+1 Hour, +5 Minute'), new DateTime('+1 Hour, +59 Minute'));
        $train5 = new Train(new DateTime('+2 Hour'), new DateTime('+3 Hour'));

        $this->lines->addTrain($train1);
        $this->lines->addTrain($train2);
        $this->lines->addTrain($train3);
        $this->lines->addTrain($train4);
        $this->lines->addTrain($train5);

        $this->assertCount(2, $this->lines);
    }

    public function testIterator()
    {
        $train1 = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $train2 = new Train(new DateTime('now'), new DateTime('+1 Hour'));

        $this->lines->addTrain($train1);
        $this->lines->addTrain($train2);

        $this->assertCount(2, $this->lines);

        $this->assertSame(0, $this->lines->key());
        $this->assertTrue($this->lines->valid());

        $line1 = $this->lines->current();
        $this->assertInstanceOf(LineInterface::class, $line1);

        $this->lines->next();
        $this->assertSame(1, $this->lines->key());
        $this->assertTrue($this->lines->valid());

        $line2 = $this->lines->current();
        $this->assertInstanceOf(LineInterface::class, $line2);

        $this->assertNotSame($line1, $line2);
    }

    /**
     * @expectedException Exception
     */
    public function testInvalidProperLine()
    {
        $this->lines = new LinesFake();
        $train = new Train(new DateTime('now'), new DateTime('+1 Hour'));
        $this->lines->addTrain($train);
    }
}