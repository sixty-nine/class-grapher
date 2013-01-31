<?php

namespace LazyGuy\AutoTest\Helper;

class Twig
{
    public static function getTwig($templateDir)
    {
        $loader = new \Twig_Loader_Filesystem($templateDir);
        return new \Twig_Environment($loader);
    }
}
