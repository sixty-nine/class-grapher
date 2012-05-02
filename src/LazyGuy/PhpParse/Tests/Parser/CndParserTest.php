<?php

namespace LazyGuy\PhpParse\Tests\Parser;

use LazyGuy\PhpParse\Reader\FileReader,
    LazyGuy\PhpParse\Parser\CndParser,
    LazyGuy\PhpParse\Scanner\GenericScanner,
    LazyGuy\PhpParse\Scanner\Context,
    LazyGuy\PhpParse\Parser\SyntaxTreeNode;

class CndParserTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $root = new SyntaxTreeNode('root');

        $node = new SyntaxTreeNode('nsMappings');
        $node->addChild(new SyntaxTreeNode('nsMapping', array('prefix' => 'ns', 'uri' => 'http://namespace.com/ns')));
        $root->addChild($node);

        $types = new SyntaxTreeNode('nodeTypes');

        $attrs = new SyntaxTreeNode('propertyTypeAttributes');
        $attrs->addChild(new SyntaxTreeNode('mandatory'));
        $attrs->addChild(new SyntaxTreeNode('autocreated'));
        $attrs->addChild(new SyntaxTreeNode('protected'));
        $attrs->addChild(new SyntaxTreeNode('multiple'));
        $attrs->addChild(new SyntaxTreeNode('VERSION'));

        $props = new SyntaxTreeNode('propertyDefs');
        $prop = new SyntaxTreeNode('propertyDef');
        $prop->addChild(new SyntaxTreeNode('propertyName', array('value' => 'ex:property')));
        $prop->addChild(new SyntaxTreeNode('propertyType', array('value' => 'STRING')));
        $prop->addChild(new SyntaxTreeNode('defaultValue', array('value' => array('default1', 'default2'))));
        $prop->addChild($attrs);
        $prop->addChild(new SyntaxTreeNode('valueConstraints', array('value' => array('constraint1', 'constraint2'))));
        $props->addChild($prop);

        $attrs = new SyntaxTreeNode('nodeAttributes');
        $attrs->addChild(new SyntaxTreeNode('mandatory'));
        $attrs->addChild(new SyntaxTreeNode('autocreated'));
        $attrs->addChild(new SyntaxTreeNode('protected'));
        $attrs->addChild(new SyntaxTreeNode('VERSION'));

        $nodes = new SyntaxTreeNode('childNodeDefs');
        $node = new SyntaxTreeNode('childNodeDef');
        $node->addChild(new SyntaxTreeNode('nodeName', array('value' => 'ns:node')));
        $node->addChild(new SyntaxTreeNode('requiredTypes', array('value' => array('ns:reqType1', 'ns:reqType2'))));
        $node->addChild(new SyntaxTreeNode('defaultType', array('value' => 'ns:defaultType')));
        $node->addChild($attrs);
        $nodes->addChild($node);

        $attrs = new SyntaxTreeNode('nodeTypeAttributes');
        $attrs->addChild(new SyntaxTreeNode('orderable'));
        $attrs->addChild(new SyntaxTreeNode('mixin'));

        $nodeType = new SyntaxTreeNode('nodeTypeDef');
        $nodeType->addChild(new SyntaxTreeNode('nodeTypeName', array('value' => 'ns:NodeType')));
        $nodeType->addChild(new SyntaxTreeNode('supertypes', array('value' => array('ns:ParentType1', 'ns:ParentType2'))));
        $nodeType->addChild($attrs);
        $nodeType->addChild($props);
        $nodeType->addChild($nodes);

        $types->addChild($nodeType);
        $root->addChild($types);

        $this->expectedExampleTree = $root;
    }

    public function testParseNormal()
    {
        $this->assertParsedFile(__DIR__ . '/../Fixtures/cnd/example.cnd', $this->expectedExampleTree);
    }

    public function testParseCompact()
    {
        $this->assertParsedFile(__DIR__ . '/../Fixtures/cnd/example.compact.cnd', $this->expectedExampleTree);
    }

    public function testParseVerbose()
    {
        $this->assertParsedFile(__DIR__ . '/../Fixtures/cnd/example.verbose.cnd', $this->expectedExampleTree);
    }

    public function testParseExample1()
    {
        // Assert there are no exceptions
        $this->parseFile(__DIR__ . '/../Fixtures/cnd/example1.cnd');
    }

    public function testParseJackrabbitBuiltin()
    {
        $this->parseFile(__DIR__ . '/../Fixtures/cnd/jackrabbit-builtin-nodetypes.cnd');

        // TODO: write some tests with this file
    }

    protected function assertParsedFile($file, $expectedCnd)
    {
        $actualCnd = $this->parseFile($file);

        $this->assertEquals($expectedCnd->dump(), $actualCnd->dump());

        $this->assertEquals($expectedCnd, $actualCnd);
    }

    protected function parseFile($file)
    {
        $reader = new FileReader($file);

        $scanner = new GenericScanner(new Context\DefaultScannerContextWithoutSpacesAndComments());
        $queue = $scanner->scan($reader);

        //define('DEBUG', true);

        $parser = new CndParser($queue);
        return $parser->parse();
    }

}
