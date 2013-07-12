<?php

namespace SixtyNine\PhpParse\Tests\Grammar;

use SixtyNine\PhpParse\Grammar\Grammar;
use SixtyNine\PhpParse\Grammar\Rule;
use SixtyNine\PhpParse\Grammar\TerminalSymbol;
use SixtyNine\PhpParse\Grammar\NonTerminalSymbol;

class GraphVizBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $grammarWithoutAxiom;

    public function setUp()
    {
        $this->axiomSymbol = new NonTerminalSymbol('axiom');
        $this->expr = new NonTerminalSymbol('expr');
        $this->plus = new TerminalSymbol('PLUS', '\\+');
        $this->mult = new TerminalSymbol('MULT', '\\*');
        $this->number = new TerminalSymbol('NUMBER', '\\d');

        $this->axiom = new Rule($this->axiomSymbol, array($this->expr), true);
        $this->axiomRule1 = new Rule($this->expr, array($this->expr, $this->mult, $this->number));
        $this->rule1 = new Rule($this->expr, array($this->expr, $this->mult, $this->number));
        $this->rule2 = new Rule($this->expr, array($this->expr, $this->plus, $this->number));
        $this->rule3 = new Rule($this->expr, array($this->number));

        $this->allRules = array($this->rule1, $this->rule2, $this->rule3);

        $this->grammarWithoutAxiom = new Grammar($this->allRules);
        $this->grammarWithAxiom = new Grammar(array($this->rule2, $this->rule3), $this->axiomRule1);
        $this->augmentedGrammar = new Grammar($this->allRules, $this->axiom);
    }

    public function test__construct()
    {
        $grammar = new Grammar();
        $this->assertAttributeEquals(array(), 'rules', $grammar);
        $this->assertAttributeEquals(null, 'axiom', $grammar);

        $this->assertAttributeEquals($this->allRules, 'rules', $this->grammarWithoutAxiom);
        $this->assertAttributeEquals(null, 'axiom', $this->grammarWithoutAxiom);

        $this->assertAttributeEquals($this->allRules, 'rules', $this->augmentedGrammar);
        $this->assertAttributeEquals($this->axiom, 'axiom', $this->augmentedGrammar);
    }

    public function testAddRule()
    {
        $grammar = new Grammar();
        $grammar->addRule($this->rule1);
        $grammar->addRule($this->rule2);
        $grammar->addRule($this->rule3);

        $this->assertAttributeEquals(null, 'axiom', $grammar);
        $this->assertAttributeEquals($this->allRules, 'rules', $grammar);

        $grammar->addRule($this->axiom);

        $this->assertAttributeEquals($this->axiom, 'axiom', $grammar);
        $this->assertAttributeEquals($this->allRules, 'rules', $grammar);
    }

    public function testGetAxiom()
    {
        // getAxiom on a grammar without axiom will return the axiom of the augmented grammar
        $this->assertAttributeEquals(null, 'axiom', $this->grammarWithoutAxiom);
        $this->assertEquals($this->axiom, $this->grammarWithoutAxiom->getAxiom());

        $this->assertEquals($this->axiom, $this->augmentedGrammar->getAxiom());
    }

    public function testGetIterator()
    {
        $this->assertEquals(new \ArrayIterator($this->allRules), $this->grammarWithoutAxiom->getIterator());
        $this->assertEquals(new \ArrayIterator(array_merge(array($this->axiom), $this->allRules)), $this->augmentedGrammar->getIterator());
    }

    public function testIsAugmentedGrammar()
    {
        $this->assertFalse($this->grammarWithoutAxiom->isAugmentedGrammar());
        $this->assertTrue($this->augmentedGrammar->isAugmentedGrammar());
    }

    public function testGetAugmentedGrammar()
    {
        $grammar = new Grammar();
        $augmentedGrammar = new Grammar(array(), new Rule($this->axiomSymbol, array(), true));

        $this->assertEquals($this->augmentedGrammar, $this->grammarWithoutAxiom->getAugmentedGrammar());
        $this->assertEquals($this->augmentedGrammar, $this->grammarWithAxiom->getAugmentedGrammar());
        $this->assertEquals($this->augmentedGrammar, $this->augmentedGrammar->getAugmentedGrammar());
        $this->assertEquals($augmentedGrammar, $grammar->getAugmentedGrammar());
    }

}