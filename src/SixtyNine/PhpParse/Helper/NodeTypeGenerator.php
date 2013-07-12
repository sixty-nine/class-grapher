<?php

namespace SixtyNine\PhpParse\Helper;

use SixtyNine\PhpParse\Parser\SyntaxTreeNode;

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
        return $visitor->getNodeTypeDefs();
    }

}
