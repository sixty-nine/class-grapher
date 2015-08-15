<?php

namespace SixtyNine\ClassGrapher\Tests\Helper;

use SixtyNine\ClassGrapher\Helper\NamespaceHelper;

class NamespaceHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBasename()
    {
        $this->assertEquals('NS4', NamespaceHelper::getBasename('NS1\\NS2\\NS3\\NS4'));
        $this->assertEquals('NS3', NamespaceHelper::getBasename('NS1\\NS2\\NS3'));
        $this->assertEquals('NS2', NamespaceHelper::getBasename('NS1\\NS2'));
        $this->assertEquals('NS1', NamespaceHelper::getBasename('NS1'));
        $this->assertEquals('',    NamespaceHelper::getBasename(''));
    }

    /**
     * Test for GetNamespace.
     */
    public function testGetNamespace()
    {
        $this->assertEquals('NS1\\NS2\\NS3', NamespaceHelper::getNamespace('NS1\\NS2\\NS3\\NS4'));
        $this->assertEquals('NS1\\NS2',      NamespaceHelper::getNamespace('NS1\\NS2\\NS3'));
        $this->assertEquals('NS1',           NamespaceHelper::getNamespace('NS1\\NS2'));
        $this->assertEquals('',              NamespaceHelper::getNamespace('NS1'));
    }

    public function testInsertNamespace()
    {
        $this->assertEquals('NS4\\NS1\\NS2\\NS3', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4'));

        $this->assertEquals('NS1\\NS4\\NS2\\NS3', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', 1));
        $this->assertEquals('NS1\\NS2\\NS4\\NS3', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', 2));
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', 3));
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', 4));
        $this->assertEquals('NS1\\NS2\\NS3\\NS4', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', 5));

        $this->assertEquals('NS1\\NS2\\NS3\\NS4', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', -1));
        $this->assertEquals('NS1\\NS2\\NS4\\NS3', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', -2));
        $this->assertEquals('NS1\\NS4\\NS2\\NS3', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', -3));
        $this->assertEquals('NS4\\NS1\\NS2\\NS3', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', -4));
        $this->assertEquals('NS4\\NS1\\NS2\\NS3', NamespaceHelper::insertNamespace('NS1\\NS2\\NS3', 'NS4', -5));
    }
}
