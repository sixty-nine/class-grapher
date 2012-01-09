<?php

namespace LazyGuy\ClassGrapher\Model;

class InterfaceItem implements ItemInterface
{
    protected $name;

    public function __construct($name = '')
    {
        $this->name = $name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}