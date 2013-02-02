<?php

namespace LazyGuy\ClassGrapher\Helper;

class NamespaceTree {

    protected $tree;

    public function __construct()
    {
        $this->tree = new NamespaceTreeItem();
    }

    public function getTree()
    {
        return $this->tree;
    }

    public function addNamespace($name)
    {
        $ns = new _Namespace($name);
        return $this->addParts($this->tree, $ns->getParts());
    }

    public function addClass($name)
    {
        $ns = new _Namespace($name);
        $node = $this->addNamespace($ns->parent());

        if (!in_array($ns->getBaseName(), $node->data)) {
            $node->data[] = $ns->getBaseName();
        }
    }

    public function prune()
    {
        $this->pruneEmptyNode($this->tree);
    }

    public function pruneAndMerge()
    {
        $this->prune();

        do {

            if (count($this->tree->children) === 1) {
                foreach ($this->tree->children as $parentName => $child) {
//                    if (count($child->children) !== 1) {
//                        return;
//                    }
                    $this->tree->children = array();
                    foreach($child->children as $childName => $subchildren) {
                        $this->tree->children[$parentName . '\\' . $childName] = $subchildren;
                    }
                }
            }

        } while(count($this->tree->children) === 1);

    }

    protected function addParts($curPart, $parts = array())
    {
        if ($part = array_shift($parts)) {
            if ($part) {
                $curPart = $curPart->addChild($part);
                return $this->addParts($curPart, $parts);
            }
        }
        return $curPart;
    }

    protected function pruneEmptyNode($curNode)
    {
        foreach ($curNode->children as $name => $child) {

            $this->pruneEmptyNode($child);

            if (empty($child->data)) {
                if (count($child->children) === 0) {
                    unset($curNode->children[$name]);
                }
            }

        }
    }

}
