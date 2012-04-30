<?php

namespace LazyGuy\Parser\Scanner\TokenFilter;

use LazyGuy\Parser\Scanner\GenericToken;

class NoWhitespacesFilter extends TokenTypeFilter
{
    function __construct()
    {
        parent::__construct(GenericToken::TK_WHITESPACE);
    }
}
