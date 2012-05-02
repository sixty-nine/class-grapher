<?php

namespace LazyGuy\PhpParse\Scanner\TokenFilter;

use LazyGuy\PhpParse\Scanner\GenericToken;

class NoWhitespacesFilter extends TokenTypeFilter
{
    function __construct()
    {
        parent::__construct(GenericToken::TK_WHITESPACE);
    }
}
