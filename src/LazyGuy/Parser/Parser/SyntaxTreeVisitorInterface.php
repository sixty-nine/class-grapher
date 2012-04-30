<?php

namespace LazyGuy\Parser\Parser;

interface SyntaxTreeVisitorInterface
{
    function visit(SyntaxTreeNode $node);
}