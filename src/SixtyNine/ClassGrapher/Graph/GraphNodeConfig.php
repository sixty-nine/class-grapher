<?php

namespace SixtyNine\ClassGrapher\Graph;

/**
 * Configuration for graph rendering
 *
 * @author D. Barsotti <sixtynine.db@gmail.com>
 */
class GraphNodeConfig
{
    /** @var string */
    protected $shape;
    /** @var string */
    protected $style;
    /** @var float */
    protected $height;

    function __construct($height, $shape, $style)
    {
        $this->height = $height;
        $this->shape = $shape;
        $this->style = $style;
    }

    /** @param float $height */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /** @return float */
    public function getHeight()
    {
        return $this->height;
    }

    /** @param string $shape */
    public function setShape($shape)
    {
        $this->shape = $shape;
        return $this;
    }

    /** @return string */
    public function getShape()
    {
        return $this->shape;
    }

    /** @param string $style */
    public function setStyle($style)
    {
        $this->style = $style;
        return $this;
    }

    /** @return string */
    public function getStyle()
    {
        return $this->style;
    }

}
