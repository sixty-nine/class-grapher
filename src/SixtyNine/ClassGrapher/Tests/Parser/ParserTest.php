<?php

namespace SixtyNine\ClassGrapher\Tests\Parser;

use SixtyNine\ClassGrapher\Model\ObjectTableBuilder;
use SixtyNine\ClassGrapher\Model\ClassItem;
use SixtyNine\ClassGrapher\Model\InterfaceItem;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $file = __DIR__ . '/../Fixtures/Classes.php';
        $ns = 'SixtyNine\\ClassGrapher\\Tests\\Fixtures\\';
        $expected = array(
            new InterfaceItem($file, $ns . 'MyInterface1'),
            new InterfaceItem($file, $ns . 'MyInterface2', array($ns . 'MyInterface1')),
            new InterfaceItem($file, $ns . 'MyInterface3', array($ns . 'MyInterface1', $ns . 'MyInterface2')),
            new ClassItem($file, $ns . 'MyClass1', array('SixtyNine\ClassGrapher\Graph\GraphViz')),
            new ClassItem($file, $ns . 'MyClass2', array(), array($ns . 'MyInterface1')),
            new ClassItem($file, $ns . 'MyClass3', array('SixtyNine\ClassGrapher\Graph\GraphViz'), array($ns . 'MyInterface1')),
            new ClassItem($file, $ns . 'MyClass4', array(), array($ns . 'MyInterface1', $ns . 'MyInterface2')),
        );

        $builder = new ObjectTableBuilder();
        $ot = $builder->build($file);

        $it = $ot->getIterator();

        $this->assertEquals(7, $it->count());
        $this->assertEquals($expected[0], $it->current());
        $it->next();
        $this->assertEquals($expected[1], $it->current());
        $it->next();
        $this->assertEquals($expected[2], $it->current());
        $it->next();
        $this->assertEquals($expected[3], $it->current());
        $it->next();
        $this->assertEquals($expected[4], $it->current());
        $it->next();
        $this->assertEquals($expected[5], $it->current());
        $it->next();
        $this->assertEquals($expected[6], $it->current());
        $it->next();
    }

    public function testParseFunctions()
    {
        $ns = 'SixtyNine\\ClassGrapher\\Tests\\Fixtures\\';
        $file = __DIR__ . '/../Fixtures/Methods.php';

        $builder = new ObjectTableBuilder();
        $ot = $builder->build($file);
        $it = $ot->getIterator();

        $this->assertEquals(1, $it->count());
        $this->assertEquals(
            array('myPublicFunction', 'myPublicFunctionWithParams', 'myProtectedFunction', 'myPrivateFunction'),
            $it->current()->getMethods()
        );
    }
}
