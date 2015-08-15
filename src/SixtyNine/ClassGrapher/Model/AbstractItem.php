<?php

namespace SixtyNine\ClassGrapher\Model;

use SixtyNine\ClassGrapher\Helper\NamespaceHelper;

abstract class AbstractItem implements ItemInterface
{
    /** @var string */
    protected $file;

    /** @var int */
    protected $line;

    /** @var string */
    protected $name;


    public function __construct($file, $line, $name)
    {
        $this->file = $file;
        $this->line = $line;
        $this->name = $name;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getLine()
    {
        return $this->line;
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

}
