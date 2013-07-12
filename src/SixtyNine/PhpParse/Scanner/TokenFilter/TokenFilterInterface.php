<?php

namespace SixtyNine\PhpParse\Scanner\TokenFilter;

use SixtyNine\PhpParse\Scanner\Token;

interface TokenFilterInterface
{
    /**
     * @abstract
     * @param Token $token
     * @return Token | null
     */
    function filter(Token $token);
}
