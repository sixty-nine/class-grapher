<?php

namespace SixtyNine\ClassGrapher\Model;

interface ItemInterface
{
    const TYPE_CLASS = 'class';
    const TYPE_INTERFACE = 'interface';

    public function getFile();
    public function getType();
    public function getName();
    public function setName($name);
    public function addMethod($methodName);
    public function getMethods();
}
