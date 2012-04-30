<?php

namespace LazyGuy\Parser\Scanner\TokenFilter;

use LazyGuy\Parser\Scanner\GenericToken;

class NoNewlinesFilter extends TokenTypeFilter
{
    function __construct()
    {
        parent::__construct(GenericToken::TK_NEWLINE);
    }
}
