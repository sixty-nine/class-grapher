<?php

namespace LazyGuy\PhpParse\Tests\Grammar;

use LazyGuy\PhpParse\Helper\NodeTypeGenerator,
    LazyGuy\PhpParse\Reader\FileReader,
    LazyGuy\PhpParse\Parser\CndParser,
    LazyGuy\PhpParse\Scanner\GenericScanner,
    LazyGuy\PhpParse\Scanner\Context;

class NodeTypeGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerator()
    {
//        $reader = new FileReader(__DIR__ . '/../Fixtures/cnd/example.cnd');
//        $scanner = new GenericScanner(new Context\DefaultScannerContextWithoutSpacesAndComments());
//        $queue = $scanner->scan($reader);
//        $parser = new CndParser($queue);
//        $root = $parser->parse();
//
//        $generator = new NodeTypeGenerator($root);
//        $generator->generate();
    }
}
