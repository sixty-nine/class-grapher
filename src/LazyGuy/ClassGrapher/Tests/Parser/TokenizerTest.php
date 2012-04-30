<?php

namespace LazyGuy\ClassGrapher\Tests\Parser;

use LazyGuy\ClassGrapher\Parser\Tokenizer;

class TokenizerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tokenizer = new Tokenizer(__DIR__ . '/../Fixtures/Methods.php');
        $this->emptyTokenizer = new Tokenizer(__DIR__ . '/../Fixtures/empty.txt');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test__construct()
    {
        $tokenizer = new Tokenizer('unexisting_file.php');
    }

    public function testIsEof()
    {
        $this->assertTrue($this->emptyTokenizer->isEof());
        $this->assertFalse($this->tokenizer->isEof());
    }

    public function testPeekToken()
    {
        $this->assertFalse($this->emptyTokenizer->peekToken());

        $this->tokenizer->reset();
        while (!$this->tokenizer->isEof()) {
            $token = $this->tokenizer->getToken();
            if (!$token) {
                break;
            }
            $this->assertInstanceOf('\LazyGuy\\ClassGrapher\\Parser\\Token', $token);
        }
        $this->assertFalse($this->tokenizer->getToken());
    }

    /**
     * @expectedException \LazyGuy\ClassGrapher\Parser\TokenizerException
     */
    public function testExpectTokenEmpty()
    {
        $this->emptyTokenizer->expectToken('foobar');
    }

    /**
     * @expectedException \LazyGuy\ClassGrapher\Parser\TokenizerException
     */
    public function testExpectTokenFailure()
    {
        $this->tokenizer->reset();
        $this->tokenizer->expectToken('foobar');
    }

    public function testExpectToken()
    {
        $tokenClass = '\LazyGuy\\ClassGrapher\\Parser\\Token';

        $this->tokenizer->reset();
        $this->assertInstanceOf($tokenClass, $this->tokenizer->expectToken('<?php', false));
        $this->assertFalse($this->tokenizer->expectToken('foobar', true));
        $this->assertInstanceOf($tokenClass, $this->tokenizer->expectToken('namespace', true));
    }
}
