<?php

namespace SixtyNine\ClassGrapher\Model;

use SixtyNine\ClassGrapher\Helper\NamespaceHelper;

class InterfaceItem implements ItemInterface
{
    protected $name;

    protected $extends;

    protected $methods;

    public function __construct($name = '', $extends = array(), $methods = array())
    {
        $this->name = $name;
        $this->extends = $extends;
        $this->methods = $methods;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBaseName()
    {
        return NamespaceHelper::getBasename($this->getName());
    }

    public function getNamespace()
    {
        return NamespaceHelper::getNamespace($this->getName());
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
}
