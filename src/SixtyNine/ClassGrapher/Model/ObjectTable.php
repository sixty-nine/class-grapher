<?php

namespace SixtyNine\ClassGrapher\Model;

class ObjectTable implements \IteratorAggregate
{
    protected $objects;

    public function __construct()
    {
        $this->objects = array();
    }

    public function add(ItemInterface $item)
    {
        if (!array_key_exists($item->getName(), $this->objects)) {
            $this->objects[$item->getName()] = $item;
        }
    }

    public function get($name)
    {
        if (!array_key_exists($name, $this->objects)) {
            throw new \InvalidArgumentException("Object not found $name");
        }

        return $this->objects[$name];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->objects);
    }
}
