<?php

namespace LazyGuy\PhpParse\Tests\Scanner;

use LazyGuy\PhpParse\Scanner\GenericScanner,
    LazyGuy\PhpParse\Reader\FileReader,
    LazyGuy\PhpParse\Scanner\GenericToken,
    LazyGuy\PhpParse\Scanner\TokenQueue,
    LazyGuy\PhpParse\Scanner\TokenFilter,
    LazyGuy\PhpParse\Scanner\Context\DefaultScannerContext;

class GenericScannerTest extends \PHPUnit_Framework_TestCase
{
    protected $expectedTokens = array(

        // <? php
        array(GenericToken::TK_SYMBOL, '<'),
        array(GenericToken::TK_SYMBOL, '?'),
        array(GenericToken::TK_IDENTIFIER, 'php'),
        array(GenericToken::TK_NEWLINE, ''),
        array(GenericToken::TK_NEWLINE, ''),

        // namespace Test\Foobar
        array(GenericToken::TK_IDENTIFIER, 'namespace'),
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_IDENTIFIER, 'Test'),
        array(GenericToken::TK_SYMBOL, '\\'),
        array(GenericToken::TK_IDENTIFIER, 'Foobar'),
        array(GenericToken::TK_SYMBOL, ';'),
        array(GenericToken::TK_NEWLINE, ''),
        array(GenericToken::TK_NEWLINE, ''),

        // class TestClass {
        array(GenericToken::TK_IDENTIFIER, 'class'),
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_IDENTIFIER, 'TestClass'),
        array(GenericToken::TK_NEWLINE, ''),
        array(GenericToken::TK_SYMBOL, '{'),
        array(GenericToken::TK_NEWLINE, ''),

        // /** ... */
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_COMMENT, "/**\n     * Block comment\n     */"),
        array(GenericToken::TK_NEWLINE, ''),

        // public function testMethod($testParam) {
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_IDENTIFIER, 'public'),
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_IDENTIFIER, 'function'),
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_IDENTIFIER, 'testMethod'),
        array(GenericToken::TK_SYMBOL, '('),
        array(GenericToken::TK_SYMBOL, '$'),
        array(GenericToken::TK_IDENTIFIER, 'testParam'),
        array(GenericToken::TK_SYMBOL, ')'),
        array(GenericToken::TK_NEWLINE, ''),
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_SYMBOL, '{'),
        array(GenericToken::TK_NEWLINE, ''),

        // // Line comment
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_COMMENT, '// Line comment'),
        array(GenericToken::TK_NEWLINE, ''),

        // $string = 'This is a "Test // string"';
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_SYMBOL, '$'),
        array(GenericToken::TK_IDENTIFIER, 'string'),
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_SYMBOL, '='),
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_STRING, '\'This is a "Test // string"\''),
        array(GenericToken::TK_SYMBOL, ';'),
        array(GenericToken::TK_NEWLINE, ''),

        // return "Test string";
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_IDENTIFIER, 'return'),
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_STRING, '"Test string"'),
        array(GenericToken::TK_SYMBOL, ';'),
        array(GenericToken::TK_NEWLINE, ''),

        // }
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_SYMBOL, '}'),
        array(GenericToken::TK_NEWLINE, ''),
        array(GenericToken::TK_NEWLINE, ''),

        // // String in "comment"
        array(GenericToken::TK_WHITESPACE, ''),
        array(GenericToken::TK_COMMENT, '// String in "comment"'),
        array(GenericToken::TK_NEWLINE, ''),

        // }
        array(GenericToken::TK_SYMBOL, '}'),
        array(GenericToken::TK_NEWLINE, ''),
    );

    protected $expectedTokensNoEmptyToken;

    public function setUp()
    {
        $this->expectedTokensNoEmptyToken = array();
        foreach($this->expectedTokens as $token) {
            if ($token[0] !== GenericToken::TK_NEWLINE && $token[0] !== GenericToken::TK_WHITESPACE) {
                $this->expectedTokensNoEmptyToken[] = $token;
            }
        }
    }

    public function testScan()
    {
        $reader = new FileReader(__DIR__ . '/../Fixtures/files/TestFile.php');

        // Test the raw file with newlines and whitespaces
        $scanner = new GenericScanner(new DefaultScannerContext());
        $queue = $scanner->scan($reader);
        $this->assertTokens($this->expectedTokens, $queue);
    }

    public function testFilteredScan()
    {
        $reader = new FileReader(__DIR__ . '/../Fixtures/files/TestFile.php');

        // Test the raw file with newlines and whitespaces
        $context = new DefaultScannerContext();
        $context->addTokenFilter(new TokenFilter\NoNewlinesFilter());
        $context->addTokenFilter(new TokenFilter\NoWhitespacesFilter());
        $scanner = new GenericScanner($context);

        $queue = $scanner->scan($reader);
        $this->assertTokens($this->expectedTokensNoEmptyToken, $queue);
    }

    protected function assertTokens($tokens, TokenQueue $queue)
    {
        $queue->reset();
        
        $it = new \ArrayIterator($tokens);

        $token = $queue->peek();

        while ($it->valid()) {

            $expectedToken = $it->current();

            $this->assertFalse($queue->isEof(), 'There is no more tokens, expected = ' . $expectedToken[1]);

            //var_dump("Expected: {$expectedToken[1]}, Found: {$token->getData()}");

            $this->assertToken($expectedToken[0], $expectedToken[1], $token);

            $token = $queue->next();
            $it->next();
        }

        $this->assertTrue($queue->isEof(), 'There are more unexpected tokens.');
    }

    protected function assertToken($type, $data, Token $token)
    {
        //var_dump($token);
        $this->assertEquals($type, $token->getType(),
            sprintf('Expected token [%s, %s], found [%s, %s]', GenericToken::getTypeName($type), $data, GenericToken::getTypeName($token->getType()), $token->getData()));

        $this->assertEquals($data, trim($token->getData()),
            sprintf('Expected token [%s, %s], found [%s, %s]', GenericToken::getTypeName($type), $data, GenericToken::getTypeName($token->getType()), $token->getData()));
    }
}
