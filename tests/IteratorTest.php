<?php
namespace IVIR3zaM\TrainStation\Tests;

use PHPUnit\Framework\TestCase;

class IteratorTest extends TestCase
{
    /**
     * @var IteratorFake
     */
    private $iterator;

    public function setUp()
    {
        $this->iterator = new IteratorFake();
    }

    public function testIterator()
    {
        $this->iterator->addObject(123);
        $this->iterator->addObject(321);

        $this->assertCount(2, $this->iterator);
        $this->assertSame(0, $this->iterator->key());
        $this->assertTrue($this->iterator->valid());
        $this->assertSame(123, $this->iterator->current());

        $this->iterator->next();
        $this->assertSame(1, $this->iterator->key());
        $this->assertTrue($this->iterator->valid());
        $this->assertSame(321, $this->iterator->current());

        $this->iterator->next();
        $this->assertSame(2, $this->iterator->key());
        $this->assertFalse($this->iterator->valid());
        $this->assertNull($this->iterator->current());

        $this->iterator->rewind();
        $this->assertSame(0, $this->iterator->key());
        $this->assertTrue($this->iterator->valid());
    }
}