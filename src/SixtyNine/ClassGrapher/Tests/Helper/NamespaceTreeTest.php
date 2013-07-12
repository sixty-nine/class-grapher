<?php

namespace SixtyNine\ClassGrapher\Tests\Helper;

use SixtyNine\ClassGrapher\Helper\NamespaceTree;

class NamespaceTreeTest extends \PHPUnit_Framework_TestCase
{
    public function testAddNamespace()
    {
        $nst = new NamespaceTree();
        $nst->addClass('NS1\\NS2\\NS3\\bla');
        $nst->addClass('NS1\\NS2\\NS3\\NS4\\test');
        $nst->addClass('NS1\\NS2\\NS3\\NS4\\test');
//        var_dump($nst);
        $nst->pruneAndMerge();
    }

    protected function getExpectedTree()
    {
        $tree = new NamespaceTree();
//        $tree->addNamespace()
    }
}
