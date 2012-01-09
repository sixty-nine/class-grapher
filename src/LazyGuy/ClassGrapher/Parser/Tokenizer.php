<?php

namespace LazyGuy\ClassGrapher\Parser;

use LazyGuy\ClassGrapher\Model,
    LazyGuy\ClassGrapher\Parser\Token;

class Tokenizer
{
    protected $fileName;

    protected $tokens;

    protected $curToken;
    
    public function __construct($fileName)
    {
        if (!file_exists($fileName)) {
            throw new InvalidArgumentException("File not found '$fileName'");
        }

        $this->curToken = 0;
        $this->fileName = $fileName;
        $this->tokens = token_get_all(file_get_contents($fileName));
    }

    public function isEof()
    {
        return $this->curToken >= count($this->tokens);
    }

    public function peekToken()
    {
        if ($this->isEof()) {
            return false;
        }

        $token = $this->tokens[$this->curToken];

        return $this->convertToken($token);
    }

    public function getToken()
    {
        $token = $this->peekToken();
        $this->forward();
        return $token;
    }

    public function expectToken($data, $optional = false, $compareType = false)
    {
        if (!$optional) {

            $token = $this->getToken();

            $testData = $compareType ? $token->type : $token->data;
            if ($testData !== $data) {
                throw new TokenizerException("Expected '$data' got '{$token->data}'");
            }

        } else {

            $token = $this->peekToken();

            $testData = $compareType ? $token->type : $token->data;
            if ($testData !== $data) {
                return false;
            }

            $this->forward(); // Consume the token
        }

        return $token;
    }

    protected function forward()
    {
        if (!$this->isEof()) {
            $this->curToken += 1;
        }
    }

    protected function convertToken($phpToken)
    {
        if (is_string($phpToken)) {
            return new Token(0, $phpToken);
        }

        return new Token($phpToken[0], $phpToken[1]);
    }

}