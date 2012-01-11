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
            new InterfaceItem($ns . 'MyInterface2', $ns . 'MyInterface1'),
            new ClassItem($ns . 'MyClass1', 'LazyGuy\ClassGrapher\Graph\GraphViz'),
            new ClassItem($ns . 'MyClass2', '', array($ns . 'MyInterface1')),
            new ClassItem($ns . 'MyClass3', 'LazyGuy\ClassGrapher\Graph\GraphViz', array($ns . 'MyInterface1')),
            new ClassItem($ns . 'MyClass4', '', array($ns . 'MyInterface1', $ns . 'MyInterface2')),
        );

        $ot = new ObjectTable();
        $resolver = new ClassResolver();
        $tokenizer = new Tokenizer(__DIR__ . '/../Fixtures/Classes.php');
        $parser = new Parser($tokenizer, $resolver, $ot);
        $parser->parse();

        $it = $ot->getIterator();

        $this->assertEquals(6, $it->count());
        $this->assertEquals($expected[0], $it->current()); $it->next();
        $this->assertEquals($expected[1], $it->current()); $it->next();
        $this->assertEquals($expected[2], $it->current()); $it->next();
        $this->assertEquals($expected[3], $it->current()); $it->next();
        $this->assertEquals($expected[4], $it->current()); $it->next();
        $this->assertEquals($expected[5], $it->current()); $it->next();
    }
}
