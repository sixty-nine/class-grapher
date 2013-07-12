<?php

namespace SixtyNine\PhpParse\PHPCR\NodeType;

use PHPCR\NodeType\NodeTypeDefinitionInterface;

class NodeTypeDefinition implements NodeTypeDefinitionInterface
{
    protected $name = '';

    protected $declaredSuperTypes = array();

    protected $isAbstract = false;

    protected $isMixin = false;

    protected $isQueryable = false;

    protected $hasOrderableChildNodes = false;

    protected $primaryItemName = '';

    protected $declaredPropertyDefinitions = array();

    protected $declaredChildNodeDefinitions = array();

    /**
     * {@InheritDoc}
     * @api
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     * @private
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@InheritDoc}
     * @api
     */
    public function getDeclaredSupertypeNames()
    {
        return $this->declaredSuperTypes;
    }

    /**
     * @param string|array $name
     * @return void
     * @private
     */
    public function addDeclaredSupertypeName($name)
    {
        $names = $name;
        if (!is_array($names)) {
            $names = array($names);
        }

        foreach ($names as $name) {
            if (!in_array($name, $this->declaredSuperTypes)) {
                $this->declaredSuperTypes[] = $name;
            }
        }
    }

    /**
     * {@InheritDoc}
     * @api
     */
    public function isAbstract()
    {
        return $this->isAbstract();
    }

    /**
     * @param bool $isAbstract
     * @return void
     * @private
     */
    public function setIsAbstract($isAbstract)
    {
        $this->isAbstract = $isAbstract;
    }

    /**
     * {@InheritDoc}
     * @api
     */
    public function isMixin()
    {
        return $this->isMixin;
    }

    /**
     * @param bool $isMixin
     * @return void
     * @private
     */
    public function setIsMixin($isMixin)
    {
        $this->isMixin = $isMixin;
    }

    /**
     * {@InheritDoc}
     * @api
     */
    public function hasOrderableChildNodes()
    {
        return $this->hasOrderableChildNodes;
    }

    /**
     * @param bool $hasOrderableChildNodes
     * @return void
     * @private
     */
    public function setHasOrderableChildNodes($hasOrderableChildNodes)
    {
        $this->hasOrderableChildNodes = $hasOrderableChildNodes;
    }

    /**
     * {@InheritDoc}
     * @api
     */
    public function isQueryable()
    {
        return $this->isQueryable;
    }

    /**
     * @param bool $isQueryable
     * @return void
     * @private
     */
    public function setIsQueryable($isQueryable)
    {
        $this->isQueryable = $isQueryable;
    }

    /**
     * {@InheritDoc}
     * @api
     */
    public function getPrimaryItemName()
    {
        return $this->primaryItemName;
    }

    /**
     * @param string $primaryItemName
     * @return void
     * @private
     */
    public function setPrimaryItemName($primaryItemName)
    {
        $this->primaryItemName = $primaryItemName;
    }

    /**
     * {@InheritDoc}
     * @api
     */
    public function getDeclaredPropertyDefinitions()
    {
        return $this->declaredPropertyDefinitions;
    }

    /**
     * @param \PHPCR\NodeType\PropertyDefinitionInterface $def
     * @return void
     * @private
     */
    public function addDeclaredPropertyDefinition(\PHPCR\NodeType\PropertyDefinitionInterface $def)
    {
        // TODO: implement
    }

    /**
     * {@InheritDoc}
     * @api
     */

    function getDeclaredChildNodeDefinitions()
    {
        return $this->declaredChildNodeDefinitions;
    }

    /**
     * @param \PHPCR\NodeType\ChildNodeDefinitionInterface $def
     * @return void
     * @private
     */
    public function addDeclaredChildNodeDefinition(\PHPCR\NodeType\ChildNodeDefinitionInterface $def)
    {
        // TODO: implement
    }

}
