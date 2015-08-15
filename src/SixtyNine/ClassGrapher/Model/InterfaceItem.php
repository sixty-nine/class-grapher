<?php

namespace SixtyNine\ClassGrapher\Model;

class InterfaceItem extends AbstractItem
{
    protected $extends;

    protected $methods;

    public function __construct($file = '', $line = 0, $name = '', $extends = array(), $methods = array())
    {
        parent::__construct($file, $line, $name);
        $this->extends = $extends;
        $this->methods = $methods;
    }

    public function addExtend($extend)
    {
        $this->extends[] = $extend;
    }

    public function setExtends($extends)
    {
        $this->extends = $extends;
    }

    public function getExtends()
    {
        return $this->extends;
    }

    public function addMethod($methodName)
    {
        if (!in_array($methodName, $this->methods)) {
            $this->methods[] = $methodName;
        }
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getType()
    {
        return ItemInterface::TYPE_INTERFACE;
    }
}
