<?php

namespace SixtyNine\ClassGrapher\Helper;

class SimpleDictionary {

    protected $data;

    protected $children;

    public function __construct()
    {
        $this->children = array();
    }

    public function addChild($key, SimpleDictionary $child)
    {
        if (!$this->childExists($key)) {
            $this->children[$key] = $child;
        }
    }

    public function getChild($key)
    {
        if (!$this->childExists($key)) {
            throw new \InvalidArgumentException("Child '$key' not found");
        }

        return $this->children[$key];
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function childExists($key)
    {
        return array_key_exists($key, $this->children);
    }

    public function find($key)
    {
        foreach ($this->children as $name => $child) {
            if ($key === $name) {
                return $child;
            }
            $res = $child->find($key);
            if ($res) {
                return $res;
            }
        }
        return false;
    }

    public function traverse(callable $callback, $parentKey = '')
    {
        $callback($this, $parentKey);
        foreach ($this->children as $key => $child) {
            $child->traverse($callback, $key);
        }
    }
}
