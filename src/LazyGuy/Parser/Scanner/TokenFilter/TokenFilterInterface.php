<?php

namespace LazyGuy\Parser\Scanner\TokenFilter;

use LazyGuy\Parser\Scanner\Token;

interface TokenFilterInterface
{
    /**
     * @abstract
     * @param Token $token
     * @return Token | null
     */
    function filter(Token $token);
}
