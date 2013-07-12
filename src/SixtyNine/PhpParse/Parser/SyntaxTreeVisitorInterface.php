<?php

namespace SixtyNine\PhpParse\Parser;

interface SyntaxTreeVisitorInterface
{
    function visit(SyntaxTreeNode $node);
}