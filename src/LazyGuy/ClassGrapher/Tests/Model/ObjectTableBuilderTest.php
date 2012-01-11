<?php

namespace LazyGuy\ClassGrapher\Tests\Model;

use LazyGuy\ClassGrapher\Model\ObjectTableBuilder;

class ObjectTableBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $ns = 'LazyGuy\\ClassGrapher\\Tests\\Fixtures\\';

        $builder = new ObjectTableBuilder();
        $table = $builder->build(__DIR__ . '/../Fixtures');
        $array = iterator_to_array($table);

        $this->assertEquals(7, count($array));

        $this->assertTrue(array_key_exists($ns . 'MyInterface1', $array));
        $this->assertTrue(array_key_exists($ns . 'MyInterface2', $array));
        $this->assertTrue(array_key_exists($ns . 'MyInterface3', $array));
        $this->assertTrue(array_key_exists($ns . 'MyClass1', $array));
        $this->assertTrue(array_key_exists($ns . 'MyClass2', $array));
        $this->assertTrue(array_key_exists($ns . 'MyClass3', $array));
        $this->assertTrue(array_key_exists($ns . 'MyClass4', $array));

        $item = $table->get($ns . 'MyInterface1');
        $this->assertInstanceOf('LazyGuy\\ClassGrapher\\Model\\InterfaceItem', $item);
        $this->assertEquals($ns . 'MyInterface1', $item->getName());

        $item = $table->get($ns . 'MyInterface2');
        $this->assertInstanceOf('LazyGuy\\ClassGrapher\\Model\\InterfaceItem', $item);
        $this->assertEquals($ns . 'MyInterface2', $item->getName());
        $this->assertEquals(array($ns . 'MyInterface1'), $item->getExtends());

        $item = $table->get($ns . 'MyInterface3');
        $this->assertInstanceOf('LazyGuy\\ClassGrapher\\Model\\InterfaceItem', $item);
        $this->assertEquals($ns . 'MyInterface3', $item->getName());
        $this->assertEquals(array($ns . 'MyInterface1', $ns . 'MyInterface2'), $item->getExtends());

        $item = $table->get($ns . 'MyClass1');
        $this->assertInstanceOf('LazyGuy\\ClassGrapher\\Model\\ClassItem', $item);
        $this->assertEquals($ns . 'MyClass1', $item->getName());
        $this->assertEquals(array('LazyGuy\\ClassGrapher\\Graph\\GraphViz'), $item->getExtends());
        $this->assertEmpty($item->getImplements());

        $item = $table->get($ns . 'MyClass2');
        $this->assertInstanceOf('LazyGuy\\ClassGrapher\\Model\\ClassItem', $item);
        $this->assertEquals($ns . 'MyClass2', $item->getName());
        $this->assertEmpty($item->getExtends());
        $this->assertEquals(array($ns . 'MyInterface1'), $item->getImplements());

        $item = $table->get($ns . 'MyClass3');
        $this->assertInstanceOf('LazyGuy\\ClassGrapher\\Model\\ClassItem', $item);
        $this->assertEquals($ns . 'MyClass3', $item->getName());
        $this->assertEquals(array('LazyGuy\\ClassGrapher\\Graph\\GraphViz'), $item->getExtends());
        $this->assertEquals(array($ns . 'MyInterface1'), $item->getImplements());

        $item = $table->get($ns . 'MyClass4');
        $this->assertInstanceOf('LazyGuy\\ClassGrapher\\Model\\ClassItem', $item);
        $this->assertEquals($ns . 'MyClass4', $item->getName());
        $this->assertEmpty($item->getExtends());
        $this->assertEquals(array($ns . 'MyInterface1', $ns . 'MyInterface2'), $item->getImplements());
    }
}
