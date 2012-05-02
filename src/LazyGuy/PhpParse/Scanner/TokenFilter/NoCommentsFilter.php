<?php

namespace LazyGuy\PhpParse\Scanner\TokenFilter;

use LazyGuy\PhpParse\Scanner\GenericToken;

class NoCommentsFilter extends TokenTypeFilter
{
    function __construct()
    {
        parent::__construct(GenericToken::TK_COMMENT);
    }
}
