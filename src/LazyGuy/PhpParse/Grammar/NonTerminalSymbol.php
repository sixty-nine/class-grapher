<?php

namespace LazyGuy\PhpParse\Grammar;

class NonTerminalSymbol extends Symbol
{
    public function __construct($id)
    {
        parent::__construct($id, false);
    }
}
