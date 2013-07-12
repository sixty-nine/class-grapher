<?php

namespace SixtyNine\PhpParse\Tests\Grammar;

use SixtyNine\PhpParse\Grammar\TerminalSymbol,
    SixtyNine\PhpParse\Grammar\NonTerminalSymbol,
    SixtyNine\PhpParse\Scanner\Token;

class SymbolTest extends \PHPUnit_Framework_TestCase
{
    public function testSymbol()
    {
        $symbol = new NonTerminalSymbol('id');
        $this->assertEquals('id', $symbol->getId());
        $this->assertFalse($symbol->getIsTerminal());

        $symbol = new TerminalSymbol('id', 'regExp');
        $this->assertEquals('id', $symbol->getId());
        $this->assertTrue($symbol->getIsTerminal());
        $this->assertEquals('regExp', $symbol->getRegExp());
        $this->assertNull($symbol->getToken());

        $symbol->setToken(new Token());
        $this->assertEquals(new Token(), $symbol->getToken());
    }
}
