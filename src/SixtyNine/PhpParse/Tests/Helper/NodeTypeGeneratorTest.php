<?php

namespace SixtyNine\PhpParse\Tests\Grammar;

use SixtyNine\PhpParse\Helper\NodeTypeGenerator,
    SixtyNine\PhpParse\Reader\FileReader,
    SixtyNine\PhpParse\Parser\CndParser,
    SixtyNine\PhpParse\Scanner\GenericScanner,
    SixtyNine\PhpParse\Scanner\Context;

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
