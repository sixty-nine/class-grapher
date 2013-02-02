<?php

namespace LazyGuy\ClassGrapher\Helper;

class _Namespace {

    protected $parts = array();

    public function __construct($namespace = '')
    {
        if ($namespace !== '') {
            $this->parts = explode('\\', $namespace);
        }
    }

    public function getParts()
    {
        return $this->parts;
    }

    /**
     * Insert the namespace $name at $position in the given $namespace.
     *
     *    - Position can be 0 or positive:
     *
     *      in this case the new namespace is inserted at the given position,
     *      zero being the start of the namespace.
     *
     *      Example:
     *          insert('NS1\\NS2\\NS3', 'NS4')     --> 'NS4\\NS1\\NS2\\NS3'
     *          insert('NS1\\NS2\\NS3', 'NS4', 1)  --> 'NS1\\NS4\\NS2\\NS3'
     *          ...
     *          insert('NS1\\NS2\\NS3', 'NS4', 3)  --> 'NS1\\NS2\\NS3\\NS4'
     *          insert('NS1\\NS2\\NS3', 'NS4', 4)  --> 'NS1\\NS2\\NS3\\NS4'
     *
     *    - Position can be negative:
     *
     *      in this case the position is calculated from the end of the string.
     *
     *      Example:
     *          insert('NS1\\NS2\\NS3', 'NS4', -1)  --> 'NS1\\NS2\\NS3\\NS4'
     *          insert('NS1\\NS2\\NS3', 'NS4', -2)  --> 'NS1\\NS2\\NS4\\NS3'
     *          insert('NS1\\NS2\\NS3', 'NS4', -3)  --> 'NS1\\NS4\\NS2\\NS3'
     *          insert('NS1\\NS2\\NS3', 'NS4', -4)  --> 'NS4\\NS1\\NS2\\NS3'
     *          insert('NS1\\NS2\\NS3', 'NS4', -5)  --> 'NS4\\NS1\\NS2\\NS3'
     *
     * @param $namespace
     * @param $name
     * @param int $position
     * @return void
     */
    public function insert($name, $position = 0)
    {
        // Fix the WTF with negative positions with too big amplitude
        if (count($this->parts) + $position + 1 < 0) {
            $position = 0;
        }

        if ($position === 0) {
            // Position = 0
            $this->parts = array_merge(
                array($name),
                $this->parts
            );
        } elseif ($position < 0) {
            // Negative position
            $this->parts = array_merge(
                array_slice($this->parts, 0, count($this->parts) + $position + 1),
                array($name),
                array_slice($this->parts, count($this->parts) + $position + 1)
            );
        } else {
            // Positive position
            $this->parts = array_merge(
                array_slice($this->parts, 0, $position),
                array($name),
                array_slice($this->parts, $position)
            );
        }

        return $this;
    }

    public function append($name)
    {
        $this->parts[] = $name;
        return $this;
    }

    public function slice($offset, $length = null)
    {
        $this->parts = array_slice($this->parts, $offset, $length);
        return $this;
    }

    public function parent()
    {
        return new _Namespace($this->getParentName());
    }

    public function getBaseName()
    {
        return basename(str_replace('\\', '/', $this));
    }

    public function getParentName()
    {
        $ns = dirname(str_replace('\\', '/', $this));
        if ($ns && $ns !== '.') {
            return str_replace('/', '\\', $ns);
        }
        return '';
    }

    public function getName()
    {
        return implode('\\', $this->parts);
    }

    public function getDirName($baseDir = '')
    {
        $name = $baseDir;
        $rest = implode('/', $this->parts);

        if (!empty($name) && $name !== '/' && !empty($rest)) {
            $name .= '/';
        }

        $name .= $rest;

        return $name;
        return $baseDir . '/' . implode('/', $this->parts);
    }

    public function __toString()
    {
        return $this->getName();
    }
}
