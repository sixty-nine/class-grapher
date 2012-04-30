<?php

namespace LazyGuy\Parser\Tests\Grammar;

use LazyGuy\Parser\Grammar\TerminalSymbol,
    LazyGuy\Parser\Grammar\NonTerminalSymbol,
    LazyGuy\Parser\Scanner\Token;

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
