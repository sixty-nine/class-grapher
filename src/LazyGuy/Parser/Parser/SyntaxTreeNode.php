<?php

namespace LazyGuy\Parser\Parser;

use LazyGuy\Parser\Grammar\Symbol;

class SyntaxTreeNode
{
    protected $symbol;

    protected $children;

    public function __construct(Symbol $symbol)
    {
        $this->symbol = $symbol;
        $this->children = array();
    }

    public function getSymbol()
    {
        return $this->symbol;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function addChild(SyntaxTreeNode $child)
    {
        $this->children[] = $child;
    }

    public function accept(SyntaxTreeVisitorInterface $visitor)
    {
        $visitor->visit($this);
        foreach($this->children as $child) {
            $child->accept($visitor);
        }
    }
}
