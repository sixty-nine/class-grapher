<?php

namespace SixtyNine\ClassGrapher\Model;

class ClassItem extends InterfaceItem
{
    protected $implements;

    public function __construct($name = '', $extends = '', $implements = array())
    {
        parent::__construct($name, $extends);
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
}