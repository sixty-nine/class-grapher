<?php

namespace LazyGuy\ClassGrapher\Tests\Helper;

use LazyGuy\ClassGrapher\Helper\NamespaceTree;
use LazyGuy\ClassGrapher\Helper\_Namespace;

class NamespaceTreeTest extends \PHPUnit_Framework_TestCase
{
    public function testAddNamespace()
    {
        $nst = new NamespaceTree();
        $nst->addClass('NS1\\NS2\\NS3\\bla');
        $nst->addClass('NS1\\NS2\\NS3\\NS4\\test');
        $nst->addClass('NS1\\NS2\\NS3\\NS4\\test');
        $nst->pruneAndMerge();
//        var_dump($nst);
    }
}
