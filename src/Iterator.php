<?php
namespace IVIR3zaM\TrainStation;

class Iterator implements \Countable, \Iterator
{
    /**
     * @var array
     */
    protected $objects = [];

    /**
     * @var int
     */
    protected $position = 0;

    public function current()
    {
        if (isset($this->objects[$this->position])) {
            return $this->objects[$this->position];
        }
    }

    public function key() : int
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid() : bool
    {
        return isset($this->objects[$this->position]);
    }

    public function count() : int
    {
        return count($this->objects);
    }
}