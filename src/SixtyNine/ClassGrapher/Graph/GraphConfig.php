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
        $this->baseFont = new GraphFontConfig(self::DEFAULT_FONT, self::DEFAULT_FONT_SIZE);;
        $this->classFont = new GraphFontConfig(self::DEFAULT_FONT, self::DEFAULT_FONT_SIZE);;
        $this->interfaceFont = new GraphFontConfig(self::DEFAULT_FONT, self::DEFAULT_FONT_SIZE);;
    }

    /** @return GraphFontConfig */
    public function getBaseFont()
    {
        return $this->baseFont;
    }

    /** @return GraphFontConfig */
    public function setBaseFont(GraphFontConfig $font)
    {
        $this->baseFont = $font;
        return $this;
    }

    /** @return GraphFontConfig */
    public function getClassFont()
    {
        return $this->classFont;
    }

    /** @param GraphFontConfig $font */
    public function setClassFont(GraphFontConfig $font)
    {
        $this->classFont = $font;
        return $this;
    }

    /** @return GraphFontConfig */
    public function getInterfaceFont()
    {
        return $this->interfaceFont;
    }

    /** @param GraphFontConfig $font */
    public function setInterfaceFont(GraphFontConfig $font)
    {
        $this->interfaceFont = $font;
        return $this;
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
