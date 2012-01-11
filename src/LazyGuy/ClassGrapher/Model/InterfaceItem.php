<?php

namespace LazyGuy\ClassGrapher\Model;

class InterfaceItem implements ItemInterface
{
    protected $name;

    protected $extends;

    public function __construct($name = '', $extends = '')
    {
        $this->name = $name;
        $this->extends = $extends;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setExtends($extends)
    {
        $this->extends = $extends;
    }

    public function getExtends()
    {
        return $this->extends;
    }
}
