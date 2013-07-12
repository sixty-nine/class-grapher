<?php

namespace SixtyNine\PhpParse\Grammar;

class TerminalSymbol extends Symbol
{
    /**
     * @var \SixtyNine\PhpParse\Scanner\Token
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
     * @param \SixtyNine\PhpParse\Scanner\Token $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return \SixtyNine\PhpParse\Scanner\Token
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
