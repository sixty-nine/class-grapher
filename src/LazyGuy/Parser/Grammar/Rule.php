<?php

namespace LazyGuy\Parser\Grammar;

class Rule
{
    /**
     * @var \LazyGuy\Parser\Parser\NonTerminalSymbol
     */
    protected $leftHand;

    /**
     * @var array
     */
    protected $rightHand;

    /**
     * @var boolean
     */
    protected $isAxiom;

    /**
     * @param NonTerminalSymbol|null $leftHand
     * @param array $rightHand
     * @param bool $isAxiom
     */
    public function __construct(NonTerminalSymbol $leftHand = null, $rightHand = array(), $isAxiom = false)
    {
        $this->leftHand = $leftHand;
        $this->rightHand = $rightHand;
        $this->isAxiom = $isAxiom;
    }

    /**
     * @return boolean
     */
    public function getIsAxiom()
    {
        return $this->isAxiom;
    }

    /**
     * @return \LazyGuy\Parser\Parser\NonTerminalSymbol|null
     */
    public function getLeftHand()
    {
        return $this->leftHand;
    }

    /**
     * @return array
     */
    public function getRightHand()
    {
        return $this->rightHand;
    }

}