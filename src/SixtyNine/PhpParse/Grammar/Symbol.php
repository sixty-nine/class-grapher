<?php

namespace SixtyNine\PhpParse\Grammar;

abstract class Symbol
{
    /**
     * @var boolean
     */
    protected $isTerminal;

    /**
     * @var string
     */
    protected $id;

    public function __construct($id, $isTerminal = false)
    {
        $this->id = $id;
        $this->isTerminal = $isTerminal;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function getIsTerminal()
    {
        return $this->isTerminal;
    }

    //@codeCoverageIgnoreStart
    public function __toString()
    {
        return sprintf('%s', $this->isTerminal ? strtoupper($this->id) : strtolower($this->id));
    }
    //@codeCoverageIgnoreEnd

}
