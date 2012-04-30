<?php

namespace LazyGuy\ClassGrapher\Tests\Parser;

use LazyGuy\ClassGrapher\Parser\ClassResolver,
    LazyGuy\ClassGrapher\Parser\Tokenizer,
    LazyGuy\ClassGrapher\Parser\Parser,
    LazyGuy\ClassGrapher\Model\ObjectTable,
    LazyGuy\ClassGrapher\Model\ClassItem,
    LazyGuy\ClassGrapher\Model\InterfaceItem;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $ns = 'LazyGuy\\ClassGrapher\\Tests\\Fixtures\\';
        $expected = array(
            new InterfaceItem($ns . 'MyInterface1'),
            new InterfaceItem($ns . 'MyInterface2', array($ns . 'MyInterface1')),
            new InterfaceItem($ns . 'MyInterface3', array($ns . 'MyInterface1', $ns . 'MyInterface2')),
            new ClassItem($ns . 'MyClass1', array('LazyGuy\ClassGrapher\Graph\GraphViz')),
            new ClassItem($ns . 'MyClass2', array(), array($ns . 'MyInterface1')),
            new ClassItem($ns . 'MyClass3', array('LazyGuy\ClassGrapher\Graph\GraphViz'), array($ns . 'MyInterface1')),
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
        $ns = 'LazyGuy\\ClassGrapher\\Tests\\Fixtures\\';

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
