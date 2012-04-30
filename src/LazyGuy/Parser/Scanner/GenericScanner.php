<?php

namespace LazyGuy\Parser\Scanner;

use LazyGuy\Parser\Reader\ReaderInterface,
    LazyGuy\Parser\Scanner\Token;

class GenericScanner extends AbstractScanner
{
    protected $whitespaces = array(" ", "\t");

    protected $stringDelimiters = array('"', '\'');

    protected $lineCommentDelimiters = array("//");

    protected $blockCommentDelimiters = array("/*" => "*/");

    protected $symbols = array(
        '<', '>', '+', '*', '%', '&', '/', '(', ')', '=', '?', '#', '|', '!', '\'', '~',
        '[', ']', '{', '}', '$', ',', ';', ':', '.', '-', '_', '\\',
    );

    /**
     * @param \LazyGuy\Parser\Reader\ReaderInterface $reader
     * @return TokenQueue
     */
    public function scan(ReaderInterface $reader)
    {
        static $counter = 0;

        while (!$reader->isEof()) {

            $this->debug('Loop');
            $this->debug('Current char: ' . $reader->currentChar());
            
            $tokenFound = false;

            $tokenFound = $tokenFound || $this->consumeComments($reader);
            $tokenFound = $tokenFound || $this->consumeNewLine($reader);
            $tokenFound = $tokenFound || $this->consumeSpaces($reader);
            $tokenFound = $tokenFound || $this->consumeString($reader);
            $tokenFound = $tokenFound || $this->consumeIdentifiers($reader);
            $tokenFound = $tokenFound || $this->consumeSymbols($reader);

            if (!$tokenFound) {
                $char = $reader->forward();
                $reader->consume();
                $token = new GenericToken(self::TK_UNKNOWN, $char);
                $this->addToken($token);
            }

        }

//        foreach ($this->getQueue as $token) {
//            echo $token . "\n";
//        }

        return $this->getQueue();
    }

    protected function consumeSpaces(ReaderInterface $reader)
    {
        $this->debug('consumeSpaces');

        if (in_array($reader->currentChar(), $this->whitespaces)) {

            $char = $reader->forwardChar();
            while (in_array($char, $this->whitespaces)) {
                $char = $reader->forwardChar();
            }

            $buffer = $reader->consume();

            $token = new GenericToken(GenericToken::TK_WHITESPACE, $buffer);
            $this->addToken($token);

            return true;
        }
    }

    protected function consumeNewLine(ReaderInterface $reader)
    {
        $this->debug('consumeNewline');

        if ($reader->currentChar() === PHP_EOL) {

            $token = new GenericToken(GenericToken::TK_NEWLINE, PHP_EOL);
            $this->addToken($token);

            $reader->consume();
            $reader->forward();
            return true;
        }
    }

    protected function consumeString(ReaderInterface $reader)
    {
        $this->debug('consumeStrings');

        $curDelimiter = $reader->currentChar();
        if (in_array($curDelimiter, $this->stringDelimiters)) {

            $char = $reader->forwardChar();
            while ($char !== $curDelimiter) {

                if ($char === PHP_EOL) {
                    throw new \Exception("ERROR: newline detected in string");
                }

                $char = $reader->forwardChar();
            }
            $reader->forward();

            $token = new GenericToken(GenericToken::TK_STRING, $reader->consume());
            $this->addToken($token);
            return true;
        }
    }

    protected function consumeComments(ReaderInterface $reader)
    {
        if ($this->consumeBlockComments($reader)) {
            return true;
        }

        return $this->consumeLineComments($reader);
    }

    protected function consumeBlockComments(ReaderInterface $reader)
    {
        $this->debug('consumeBlockComments');

        $nextChar = $reader->currentChar();
        foreach($this->blockCommentDelimiters as $beginDelim => $endDelim) {

            if (!$beginDelim || !$endDelim) {
                continue;
            }

            if ($nextChar === $beginDelim[0]) {

                // Lookup the start delimiter
                for ($i = 1; $i <= strlen($beginDelim); $i++) {
                    $reader->forward();
                }

                if ($reader->current() === $beginDelim) {

                    // Start delimiter found, let's try to find the end delimiter
                    $nextChar = $reader->forwardChar();
                    while ($nextChar) {

                        if ($nextChar === $endDelim[0]) {

                            for ($i = 1; $i <= strlen($endDelim); $i++) {
                                $reader->forward();
                            }

                            if (substr($reader->current(), -2) === $endDelim) {
                                $token = new GenericToken(GenericToken::TK_COMMENT, $reader->consume());
                                $this->addToken($token);

                                return true;
                            }
                        }

                        $nextChar = $reader->forwardChar();
                    }

                    // End of file reached and no end delimiter found, error
                    throw new \Exception("Unterminated block comment");

                } else {

                    // Start delimiter not found, rewind the looked up characters
                    $reader->rewind();
                    return false;
                }

            }

        }

    }

    protected function consumeLineComments(ReaderInterface $reader)
    {
        $this->debug('consumeLineComments');

        $nextChar = $reader->currentChar();
        foreach($this->lineCommentDelimiters as $delimiter) {

            if ($delimiter && $nextChar === $delimiter[0]) {

                for ($i = 1; $i <= strlen($delimiter); $i++) {
                    $reader->forward();
                }

                if ($reader->current() === $delimiter) {

                    // consume to end of line
                    $char = $reader->currentChar();
                    while (!$reader->isEof() && $char !== PHP_EOL) {
                        $char = $reader->forwardChar();
                    }
                    $token = new GenericToken(GenericToken::TK_COMMENT, $reader->consume());
                    $this->addToken($token);

                    return true;

                } else {

                    // Rewind the looked up characters
                    $reader->rewind();
                    return false;
                }

            }
        }
    }

    protected function consumeIdentifiers(ReaderInterface $reader)
    {
        $this->debug('consumeIdentifiers');

        $nextChar = $reader->currentChar();
        if (preg_match('/[a-zA-Z]/', $nextChar)) {
            $nextChar = $reader->forwardChar();
            while (preg_match('/[a-zA-Z0-9_]/', $nextChar)) {
                $nextChar = $reader->forwardChar();
            }
            $token = new GenericToken(GenericToken::TK_IDENTIFIER, $reader->consume());
            $this->addToken($token);
            return true;
        }
    }

    protected function consumeSymbols(ReaderInterface $reader)
    {
        $this->debug('consumeSymbols');

        $found = false;
        $nextChar = $reader->currentChar();
        while (in_array($nextChar, $this->symbols)) {
            $found = true;
            $token = new GenericToken(GenericToken::TK_SYMBOL, $nextChar);
            $this->addToken($token);

            $reader->consume();
            $nextChar = $reader->forwardChar();
        }

        $reader->consume();

        return $found;
    }

}
