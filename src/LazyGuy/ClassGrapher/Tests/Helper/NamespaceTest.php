<?php

namespace LazyGuy\ClassGrapher\Tests\Helper;

use LazyGuy\ClassGrapher\Helper\_Namespace;

class NamespaceTest extends \PHPUnit_Framework_TestCase
{
    public function testParent()
    {
        $ns = new _Namespace('NS1\\NS2\\NS3\\NS4');

        $this->assertEquals('NS4', $ns->getBaseName());
        $this->assertEquals('NS1\\NS2\\NS3', $ns->getParentName());
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', $ns->getName());
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', $ns);

        $ns = $ns->parent();
        $this->assertEquals('NS3', $ns->getBaseName());
        $this->assertEquals('NS1\\NS2', $ns->getParentName());
        $this->assertEquals('NS1\\NS2\\NS3', $ns->getName());
        $this->assertEquals('NS1\\NS2\\NS3', $ns);

        $ns = $ns->parent();
        $this->assertEquals('NS2', $ns->getBaseName());
        $this->assertEquals('NS1', $ns->getParentName());
        $this->assertEquals('NS1\\NS2', $ns->getName());
        $this->assertEquals('NS1\\NS2', $ns);

        $ns = $ns->parent();
        $this->assertEquals('NS1', $ns->getBaseName());
        $this->assertEquals('', $ns->getParentName());
        $this->assertEquals('NS1', $ns->getName());
        $this->assertEquals('NS1', $ns);

        $ns = $ns->parent();
        $this->assertEquals('', $ns->getBaseName());
        $this->assertEquals('', $ns->getParentName());
        $this->assertEquals('', $ns->getName());
        $this->assertEquals('', $ns);

        $ns = $ns->parent();
        $this->assertEquals('', $ns->getBaseName());
        $this->assertEquals('', $ns->getParentName());
        $this->assertEquals('', $ns->getName());
        $this->assertEquals('', $ns);
    }

    public function testAppend()
    {
        $ns = new _Namespace();
        $this->assertEquals('NS1', $ns->append('NS1'));
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', $this->getBaseNs()->append('NS4'));
    }

    public function testInsert()
    {
        $this->assertEquals('NS4\\NS1\\NS2\\NS3', $this->getBaseNs()->insert('NS4'));

        $this->assertEquals('NS1\\NS4\\NS2\\NS3', $this->getBaseNs()->insert('NS4', 1));
        $this->assertEquals('NS1\\NS2\\NS4\\NS3', $this->getBaseNs()->insert('NS4', 2));
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', $this->getBaseNs()->insert('NS4', 3));
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', $this->getBaseNs()->insert('NS4', 4));
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', $this->getBaseNs()->insert('NS4', 5));

        $this->assertEquals('NS1\\NS2\\NS3\\NS4', $this->getBaseNs()->insert('NS4', -1));
        $this->assertEquals('NS1\\NS2\\NS4\\NS3', $this->getBaseNs()->insert('NS4', -2));
        $this->assertEquals('NS1\\NS4\\NS2\\NS3', $this->getBaseNs()->insert('NS4', -3));
        $this->assertEquals('NS4\\NS1\\NS2\\NS3', $this->getBaseNs()->insert('NS4', -4));
        $this->assertEquals('NS4\\NS1\\NS2\\NS3', $this->getBaseNs()->insert('NS4', -5));
    }

    public function testGetDirName()
    {
        $ns = new _Namespace();
        $this->assertEquals('', $ns->getDirName());
        $this->assertEquals('/', $ns->getDirName('/'));
        $this->assertEquals('test1/test2', $ns->getDirName('test1/test2'));
        $this->assertEquals('/test1/test2', $ns->getDirName('/test1/test2'));
        $this->assertEquals('NS1/NS2/NS3', $this->getBaseNs()->getDirName());
        $this->assertEquals('/test1/test2/NS1/NS2/NS3', $this->getBaseNs()->getDirName('/test1/test2'));
    }

    protected function getBaseNs()
    {
        return new _Namespace('NS1\\NS2\\NS3');
    }
}
