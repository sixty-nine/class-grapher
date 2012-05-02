<?php

namespace LazyGuy\PhpParse\Helper;

use LazyGuy\PhpParse\Parser\SyntaxTreeNode;

class NodeTypeGenerator
{
    protected $root;

    public function __construct(SyntaxTreeNode $root)
    {
        $this->root = $root;
    }

    public function generate()
    {
        $visitor = new CndSyntaxTreeNodeVisitor($this);
        $this->root->accept($visitor);
        var_dump($visitor->getNodeTypeDefs());
    }

}
