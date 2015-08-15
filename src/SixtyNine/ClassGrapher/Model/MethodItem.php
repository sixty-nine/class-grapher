<?php

namespace SixtyNine\ClassGrapher\Model;

class MethodItem extends AbstractItem
{
    public function __construct($file = '', $line = 0, $name = '')
    {
        parent::__construct($file, $line, $name);
    }

    public function getType()
    {
        return ItemInterface::TYPE_METHOD;
    }
}
