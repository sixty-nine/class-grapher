<?php

namespace LazyGuy\ClassGrapher\Model;

interface ItemInterface {

    function getName();
    function setName($name);
    function addMethod($methodName);
    function getMethods();
}
