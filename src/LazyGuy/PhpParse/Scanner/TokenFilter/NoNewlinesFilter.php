<?php

namespace LazyGuy\PhpParse\Scanner\TokenFilter;

use LazyGuy\PhpParse\Scanner\GenericToken;

class NoNewlinesFilter extends TokenTypeFilter
{
    function __construct()
    {
        parent::__construct(GenericToken::TK_NEWLINE);
    }
}
