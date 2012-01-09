<?php

namespace LazyGuy\ClassGrapher\Model;

class ClassItem extends InterfaceItem
{
    protected $extends;

    protected $implements;

    public function __construct($name = '', $extends = '', $implements = array())
    {
        parent::__construct($name);
        $this->extends = $extends;
        $this->implements = $implements;
    }

    public function setExtends($extends)
    {
        $this->extends = $extends;
    }

    public function getExtends()
    {
        return $this->extends;
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