<?php

namespace LazyGuy\Parser\Parser;

interface ParserInterface
{
    /**
     * @abstract
     * @param TokenQueue $queue
     * @return SyntaxTreeNode The root node of the syntax tree
     */
    function parse(TokenQueue $queue);
}
