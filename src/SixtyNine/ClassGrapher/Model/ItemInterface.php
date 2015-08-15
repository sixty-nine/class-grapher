<?php

namespace SixtyNine\ClassGrapher\Model;

interface ItemInterface
{
    const TYPE_CLASS = 'class';
    const TYPE_INTERFACE = 'interface';

    function getFile();
    function getType();
    function getName();
    function setName($name);
    function addMethod($methodName);
    function getMethods();
}
