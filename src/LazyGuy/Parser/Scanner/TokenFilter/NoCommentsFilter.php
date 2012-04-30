<?php

namespace LazyGuy\Parser\Scanner\TokenFilter;

use LazyGuy\Parser\Scanner\GenericToken;

class NoCommentsFilter extends TokenTypeFilter
{
    function __construct()
    {
        parent::__construct(GenericToken::TK_COMMENT);
    }
}
