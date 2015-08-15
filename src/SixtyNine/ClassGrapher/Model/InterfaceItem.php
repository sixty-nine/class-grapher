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

    public function addMethod($file, $line, $methodName)
    {
        if (!array_key_exists($methodName, $this->methods)) {
            $this->methods[$methodName] = new MethodItem($file, $line, $methodName);
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
