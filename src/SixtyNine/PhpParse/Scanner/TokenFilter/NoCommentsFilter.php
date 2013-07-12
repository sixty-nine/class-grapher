<?php

namespace SixtyNine\PhpParse\Scanner\TokenFilter;

use SixtyNine\PhpParse\Scanner\GenericToken;

class NoCommentsFilter extends TokenTypeFilter
{
    function __construct()
    {
        parent::__construct(GenericToken::TK_COMMENT);
    }
}
