<?php

namespace SixtyNine\ClassGrapher\Graph;

/**
 * Configuration for graph rendering
 *
 * @author D. Barsotti <sixtynine.db@gmail.com>
 */
class GraphConfig
{
    const DEFAULT_FONT = 'AvantGarde-Book';
    const DEFAULT_FONT_SIZE = 8;

    const DEFAULT_NODE_SHAPE = 'box';
    const DEFAULT_NODE_STYLE = '';
    const DEFAULT_NODE_HEIGHT = 0.25;

    /** @var GraphNodeConfig */
    protected $classNode;
    /** @var GraphNodeConfig */
    protected $interfaceNode;
    /** @var GraphFontConfig */
    protected $baseFont;
    /** @var GraphFontConfig */
    protected $classFont;
    /** @var GraphFontConfig */
    protected $interfaceFont;
    /** @var bool */
    protected $showEdges = true;
    /** @var bool */
    protected $showGroups = false;

    public function __construct()
    {
        $this->classNode = new GraphNodeConfig(self::DEFAULT_NODE_HEIGHT, self::DEFAULT_NODE_SHAPE, self::DEFAULT_NODE_STYLE);
        $this->interfaceNode = new GraphNodeConfig(self::DEFAULT_NODE_HEIGHT, self::DEFAULT_NODE_SHAPE, self::DEFAULT_NODE_STYLE);
        $this->baseFont = new GraphFontConfig(self::DEFAULT_FONT, self::DEFAULT_FONT_SIZE);;
        $this->classFont = new GraphFontConfig(self::DEFAULT_FONT, self::DEFAULT_FONT_SIZE);;
        $this->interfaceFont = new GraphFontConfig(self::DEFAULT_FONT, self::DEFAULT_FONT_SIZE);;
    }

    /** @return GraphNodeConfig */
    public function getClassNode()
    {
        return $this->classNode;
    }

    /** @return GraphNodeConfig */
    public function getInterfaceNode()
    {
        return $this->interfaceNode;
    }

    /** @return GraphFontConfig */
    public function getBaseFont()
    {
        return $this->baseFont;
    }

    /** @return GraphFontConfig */
    public function getClassFont()
    {
        return $this->classFont;
    }

    /** @return GraphFontConfig */
    public function getInterfaceFont()
    {
        return $this->interfaceFont;
    }

    /** @param boolean $showEdges */
    public function setShowEdges($showEdges)
    {
        $this->showEdges = $showEdges;
        return $this;
    }

    /** @return boolean */
    public function getShowEdges()
    {
        return $this->showEdges;
    }

    /** @param boolean $showGroups */
    public function setShowGroups($showGroups)
    {
        $this->showGroups = $showGroups;
        return $this;
    }

    /** @return boolean */
    public function getShowGroups()
    {
        return $this->showGroups;
    }

}
