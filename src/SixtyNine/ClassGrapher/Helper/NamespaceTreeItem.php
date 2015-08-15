<?php

namespace SixtyNine\ClassGrapher\Helper;

class NamespaceTreeItem
{

    public $data = array();
    public $children = array();

    public function addChild($name) {
        if (!array_key_exists($name, $this->children)) {
            $child = new NamespaceTreeItem($name);
            $this->children[$name] = $child;
        }
        return $this->children[$name];
    }
}
