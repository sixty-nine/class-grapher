<?php

namespace LazyGuy\Parser\CndParser;

use LazyGuy\Parser\Scanner\Token;

class CndToken extends Token
{
    const CND_WHITESPACE = 0;
    const CND_SYMBOL = 1;
    const CND_LINE_COMMENT_START = 2;
    const CND_BLOCK_COMMENT_START = 3;
    const CND_BLOCK_COMMENT_END = 4;
    const CND_IDENTIFIER = 5;
}
