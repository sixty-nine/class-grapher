<?php

namespace LazyGuy\PhpParse\Grammar;

class Grammar implements \IteratorAggregate
{
    protected $axiom;

    protected $rules;

    public function __construct($rules = array(), Rule $axiom = null)
    {
        $this->rules = $rules;
        $this->axiom = $axiom;
    }

    public function addRule(Rule $rule)
    {
        if ($rule->getIsAxiom()) {
            $this->axiom = $rule;
        } else {
            $this->rules[] = $rule;
        }
    }

    public function getAxiom()
    {
        if (is_null($this->axiom)) {
            return $this->getAugmentedGrammar()->getAxiom();
        }
        
        return $this->axiom;
    }

    public function getIterator()
    {
        $rules = $this->rules;
        if ($this->axiom) {
            $rules = array_merge(array($this->axiom), $rules);
        }
        return new \ArrayIterator($rules);
    }

    public function isAugmentedGrammar()
    {
        if ($this->axiom) {
            $right = $this->axiom->getRightHand();
            return count($right) === 1 && $right[0] instanceof NonTerminalSymbol;
        }

        return !is_null($this->axiom);
    }

    public function getAugmentedGrammar()
    {
        if (!$this->isAugmentedGrammar()) {
            if ($this->axiom) {
                $axiom = new Rule(new NonTerminalSymbol('axiom'), array($this->axiom->getLeftHand()), true);
                $rules = array_merge(
                    array(new Rule($this->axiom->getLeftHand(), $this->axiom->getRightHand())),
                    $this->rules
                );
            } else {
                if (count($this->rules)) {
                    $axiom = new Rule(new NonTerminalSymbol('axiom'), array($this->rules[0]->getLeftHand()), true);
                } else {
                    $axiom = new Rule(new NonTerminalSymbol('axiom'), array(), true);
                }
                $rules = $this->rules;
            }
            return new Grammar($rules, $axiom);
        }
        return $this;
    }

    //@codeCoverageIgnoreStart
    public function __toString()
    {
        $res = '';
        foreach ($this->getIterator() as $rule) {

            $right = '';
            foreach($rule->getRightHand() as $item) {
                $right .= $item . ' ';
            }

            $res .= sprintf("%s --> %s    %s\n", $rule->getLeftHand(), $right, $rule->getIsAxiom() ? '!!! AXIOM' : '');
        }
        return $res;
    }
    //@codeCoverageIgnoreEnd

}
