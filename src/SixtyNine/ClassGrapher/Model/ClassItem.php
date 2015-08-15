<?php

namespace SixtyNine\ClassGrapher\Model;

class ClassItem extends InterfaceItem
{
    protected $implements;

    public function __construct($file = '', $name = '', $extends = '', $implements = array())
    {
        parent::__construct($file, $name, $extends);
        $this->implements = $implements;
    }

    public function setImplements($implements)
    {
        $this->implements = $implements;
    }

    public function addImplement($implement)
    {
        if(!in_array($implement, $this->implements)) {
            $this->implements[] = $implement;
        }
    }

    public function getImplements()
    {
        return $this->implements;
    }

    function getType()
    {
        return ItemInterface::TYPE_CLASS;
    }
}