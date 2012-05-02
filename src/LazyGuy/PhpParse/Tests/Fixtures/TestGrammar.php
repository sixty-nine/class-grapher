<?php

namespace LazyGuy\PhpParse\Tests\Fixtures;

use LazyGuy\PhpParse\Parser\Grammar,
    LazyGuy\PhpParse\Parser\NonTerminalSymbol,
    LazyGuy\PhpParse\Parser\TerminalSymbol,
    LazyGuy\PhpParse\Parser\Rule;

class TestGrammar extends Grammar
{
    /**
     * Create the grammar:
     *
     *  E --> E * number
     *  E --> E + number
     *  E --> number
     */
    public function __construct()
    {
        parent::__construct();

        $expr = new NonTerminalSymbol('expr');
        $plus = new TerminalSymbol('PLUS', '\\+');
        $mult = new TerminalSymbol('MULT', '\\*');
        $number = new TerminalSymbol('NUMBER', '\\d');

        $this->addRule(new Rule($expr, array($expr, $mult, $number), true));
        $this->addRule(new Rule($expr, array($expr, $plus, $number)));
        $this->addRule(new Rule($expr, array($number)));
    }
}