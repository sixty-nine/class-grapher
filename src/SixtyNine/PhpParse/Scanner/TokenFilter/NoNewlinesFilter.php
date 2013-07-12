<?php

namespace SixtyNine\PhpParse\Scanner\TokenFilter;

use SixtyNine\PhpParse\Scanner\GenericToken;

class NoNewlinesFilter extends TokenTypeFilter
{
    function __construct()
    {
        parent::__construct(GenericToken::TK_NEWLINE);
    }
}
