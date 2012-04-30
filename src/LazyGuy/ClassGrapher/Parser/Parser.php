<?php

namespace LazyGuy\ClassGrapher\Parser;

use LazyGuy\ClassGrapher\Model\ObjectTable,
    LazyGuy\ClassGrapher\Model\ClassItem,
    LazyGuy\ClassGrapher\Model\InterfaceItem;

/**
 * Parse a PHP file through a tokenizer and extract the classes and interfaces information into an object table
 *
 * @author D. Barsotti <info@dreamcraft.ch>
 */
class Parser
{
    /**
     * The current namespace with a trailing backslash
     * @var string
     */
    protected $curNamespace;

    /**
     * @var \LazyGuy\ClassGrapher\Parser\ClassResolver
     */
    protected $classResolver;

    /**
     * @var \LazyGuy\ClassGrapher\Model\ObjectTable
     */
    protected $objectTable;

    /**
     * @var \LazyGuy\ClassGrapher\Parser\Tokenizer
     */
    protected $tokenizer;

    /**
     * @var \LazyGuy\ClassGrapher\Model\ItemInterface
     */
    protected $currentItem;

    /**
     * Constructor
     * @param Tokenizer $tokenizer
     * @param ClassResolver $classResolver
     * @param \LazyGuy\ClassGrapher\Model\ObjectTable $objectTable
     */
    public function __construct(Tokenizer $tokenizer, ClassResolver $classResolver, ObjectTable $objectTable)
    {
        $this->tokenizer = $tokenizer;
        $this->classResolver = $classResolver;
        $this->objectTable = $objectTable;
        $this->curNamespace = '';
    }

    /**
     * Parse the tokens from the tokenizer
     * @return void
     */
    public function parse()
    {
        while (!$this->tokenizer->isEof()) {

            if ($token = $this->tokenizer->peekToken()) {

                //var_dump(sprintf('%s[%s]', token_name($token->type), $token->data));

                switch ($token->type) {
                    case T_USE:
                        $this->parseUse();
                        break;
                    case T_NAMESPACE:
                        $this->parseNamespace();
                        break;
                    case T_CLASS:
                        $this->parseClass();
                        break;
                    case T_INTERFACE:
                        $this->parseInterface();
                        break;
                    case T_FUNCTION:
                        $this->parseFunction();
                        break;
                    default:
                        // Consume the token
                        $this->tokenizer->getToken();
                }
            }
        }
    }

    /**
     * Parse a "use" statement and update the class resolver
     * @return void
     */
    protected function parseUse()
    {
        $this->tokenizer->expectToken(T_USE, false, true);

        while (true) {

            $alias = '';
            $fqn = $this->parseIdentifier();

            if ($this->tokenizer->peekToken()->type === T_AS) {
                $this->tokenizer->expectToken(T_AS, false, true);
                $alias = $this->parseIdentifier();
            }

            $this->classResolver->addUse($fqn, $alias);

            if ($this->tokenizer->peekToken()->data === ',') {
                $this->tokenizer->getToken();
            } else {
                break;
            }

        }
    }

    /**
     * Parse a "namespace" statement and update the current namespace
     * @return void
     */
    protected function parseNamespace()
    {
        $this->tokenizer->getToken();
        $this->curNamespace = $this->parseIdentifier();
        $this->classResolver->setNamespace($this->curNamespace);
    }

    /**
     * Parse a "class" statement
     * @return void
     */
    protected function parseClass()
    {
        $extends = array();
        $implements = array();
        
        $this->tokenizer->getToken();
        $name = $this->parseIdentifier();

        if ($this->tokenizer->peekToken()->type === T_EXTENDS) {

            $this->tokenizer->expectToken(T_EXTENDS, false, true);
            $extends = array($this->parseIdentifier());
        }

        if ($this->tokenizer->peekToken()->type === T_IMPLEMENTS) {

            $this->tokenizer->expectToken(T_IMPLEMENTS, false, true);

            while (true) {
                $implements[] = $this->parseIdentifier();

                if ($this->tokenizer->peekToken()->data === ',') {
                    $this->tokenizer->getToken();
                } else {
                    break;
                }
            }
        }

        $this->addClassToTable($name, $extends, $implements);
    }

    /**
     * Parse an "interface" statement
     * @return void
     */
    protected function parseInterface()
    {
        $extends = array();
        $this->tokenizer->expectToken(T_INTERFACE, false, true);
        $name = $this->classResolver->resolve($this->parseIdentifier());

        if ($this->tokenizer->peekToken()->type === T_EXTENDS) {

            $this->tokenizer->expectToken(T_EXTENDS, false, true);

            while (true) {

                $extends[] = $this->classResolver->resolve($this->parseIdentifier());

                if ($this->tokenizer->peekToken()->data === ',') {
                    $this->tokenizer->getToken();
                } else {
                    break;
                }
            }

        }

        $this->objectTable->add(new InterfaceItem($name, $extends));
    }

    protected function parseFunction()
    {
        $this->tokenizer->expectToken(T_FUNCTION, false, true);
        $name = $this->parseIdentifier();
        if ($this->currentItem) {
            $this->currentItem->addMethod($name);
        }
    }

    /**
     * Parse a PHP fully qualified class name in the form: ns1\ns2\...\nsn\class
     * @return string The FQN or empty if none was found
     */
    protected function parseIdentifier()
    {
        $buffer = '';

        $token = $this->tokenizer->peekToken();
        while (in_array($token->type, array(T_STRING, T_NS_SEPARATOR))) {
            $buffer .= $this->tokenizer->getToken()->data;
            $token = $this->tokenizer->peekToken();
        }

        return $buffer;
    }

    /**
     * Add a class to the object table and resolve its name, parent name and implemented interfaces names
     * @param string $name The name of the class
     * @param string $extends The extended parent class name
     * @param array $implements An array of implemented interfaces names
     * @return void
     */
    protected function addClassToTable($name, $extends, $implements)
    {
        $name = $this->curNamespace . '\\' . $name;

        $resolvedExtends = array();
        foreach($extends as $extend) {
            $resolvedExtends[] = $this->classResolver->resolve($extend);
        }

        $resolvedImplements = array();
        foreach($implements as $interface) {
            $resolvedImplements[] = $this->classResolver->resolve($interface);
        }

        $item = new ClassItem($name, $resolvedExtends, $resolvedImplements);
        $this->currentItem = $item;
        $this->objectTable->add($item);
    }
}