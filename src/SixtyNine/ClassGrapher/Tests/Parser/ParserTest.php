<?php

namespace SixtyNine\ClassGrapher\Tests\Parser;

use SixtyNine\ClassGrapher\Parser\ClassResolver;
use SixtyNine\ClassGrapher\Parser\Tokenizer;
use SixtyNine\ClassGrapher\Parser\Parser;
use SixtyNine\ClassGrapher\Model\ObjectTable;
use SixtyNine\ClassGrapher\Model\ClassItem;
use SixtyNine\ClassGrapher\Model\InterfaceItem;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $ns = 'SixtyNine\\ClassGrapher\\Tests\\Fixtures\\';
        $expected = array(
            new InterfaceItem($ns . 'MyInterface1'),
            new InterfaceItem($ns . 'MyInterface2', array($ns . 'MyInterface1')),
            new InterfaceItem($ns . 'MyInterface3', array($ns . 'MyInterface1', $ns . 'MyInterface2')),
            new ClassItem($ns . 'MyClass1', array('SixtyNine\ClassGrapher\Graph\GraphViz')),
            new ClassItem($ns . 'MyClass2', array(), array($ns . 'MyInterface1')),
            new ClassItem($ns . 'MyClass3', array('SixtyNine\ClassGrapher\Graph\GraphViz'), array($ns . 'MyInterface1')),
            new ClassItem($ns . 'MyClass4', array(), array($ns . 'MyInterface1', $ns . 'MyInterface2')),
        );

        $ot = new ObjectTable();
        $resolver = new ClassResolver();
        $tokenizer = new Tokenizer(__DIR__ . '/../Fixtures/Classes.php');
        $parser = new Parser($tokenizer, $resolver, $ot);
        $parser->parse();

        $it = $ot->getIterator();

        $this->assertEquals(7, $it->count());
        $this->assertEquals($expected[0], $it->current()); $it->next();
        $this->assertEquals($expected[1], $it->current()); $it->next();
        $this->assertEquals($expected[2], $it->current()); $it->next();
        $this->assertEquals($expected[3], $it->current()); $it->next();
        $this->assertEquals($expected[4], $it->current()); $it->next();
        $this->assertEquals($expected[5], $it->current()); $it->next();
        $this->assertEquals($expected[6], $it->current()); $it->next();
    }

    public function testParseFunctions()
    {
        $ns = 'SixtyNine\\ClassGrapher\\Tests\\Fixtures\\';

        $ot = new ObjectTable();
        $resolver = new ClassResolver();
        $tokenizer = new Tokenizer(__DIR__ . '/../Fixtures/Methods.php');
        $parser = new Parser($tokenizer, $resolver, $ot);
        $parser->parse();

        $it = $ot->getIterator();

        $this->assertEquals(1, $it->count());
        $this->assertEquals(
            array("myPublicFunction", "myPublicFunctionWithParams", "myProtectedFunction", "myPrivateFunction"),
            $it->current()->getMethods()
        );
    }
}
