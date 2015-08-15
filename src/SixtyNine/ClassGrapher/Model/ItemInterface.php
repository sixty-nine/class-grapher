<?php

namespace SixtyNine\ClassGrapher\Model;

interface ItemInterface
{
    const TYPE_CLASS = 'class';
    const TYPE_INTERFACE = 'interface';
    const TYPE_METHOD = 'method';

    function getFile();
    function getType();
    function getLine();
    function getName();
    function setName($name);
}
