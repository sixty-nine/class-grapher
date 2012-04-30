<?php

namespace LazyGuy\Parser\Grammar;

class TerminalSymbol extends Symbol
{
    /**
     * @var \LazyGuy\Parser\Scanner\Token
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
     * @param \LazyGuy\Parser\Scanner\Token $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return \LazyGuy\Parser\Scanner\Token
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
