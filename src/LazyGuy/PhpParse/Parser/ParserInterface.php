<?php

namespace LazyGuy\PhpParse\Parser;

interface ParserInterface
{
    /**
     * @return SyntaxTreeNode The root node of the syntax tree
     */
    function parse();
}
