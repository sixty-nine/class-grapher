<?php

namespace LazyGuy\PhpParse\Parser;

interface SyntaxTreeVisitorInterface
{
    function visit(SyntaxTreeNode $node);
}