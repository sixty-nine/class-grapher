<?php

namespace LazyGuy\PhpParse\Grammar;

class TerminalSymbol extends Symbol
{
    /**
     * @var \LazyGuy\PhpParse\Scanner\Token
     */
    protected $token;

    /**
     * @var string
     */
    protected $regExp;

    public function __construct($id, $regExp)
    {
        parent::__construct($id, true);

        $this->regExp = $regExp;
    }

    /**
     * @param \LazyGuy\PhpParse\Scanner\Token $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return \LazyGuy\PhpParse\Scanner\Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getRegExp()
    {
        return $this->regExp;
    }
}
