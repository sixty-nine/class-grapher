<?php

namespace SixtyNine\PhpParse\Tests\Grammar;

use SixtyNine\PhpParse\Grammar\TerminalSymbol;
use SixtyNine\PhpParse\Grammar\NonTerminalSymbol;
use SixtyNine\PhpParse\Scanner\Token;

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
