<?php

namespace LazyGuy\PhpParse\Scanner\TokenFilter;

use LazyGuy\PhpParse\Scanner\Token;

interface TokenFilterInterface
{
    /**
     * @abstract
     * @param Token $token
     * @return Token | null
     */
    function filter(Token $token);
}
