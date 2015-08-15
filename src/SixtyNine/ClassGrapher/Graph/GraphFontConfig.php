<?php

namespace SixtyNine\ClassGrapher\Graph;

/**
 * Configuration for graph rendering
 *
 * @author D. Barsotti <sixtynine.db@gmail.com>
 */
class GraphFontConfig
{
    const FONT_NORMAL = 0;
    const FONT_BOLD = 1;
    const FONT_ITALIC = 2;

    /** @var string */
    protected $font;
    /** @var int */
    protected $size;
    /** @var int */
    protected $style;
    /** @var string */
    protected $color;

    public function __construct($font, $size, $color = 'black', $style = self::FONT_NORMAL)
    {
        $this->font = $font;
        $this->color = $color;
        $this->style = $style;
        $this->size = $size;
    }

    /** @param string $color */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /** @return string */
    public function getColor()
    {
        return $this->color;
    }

    /** @param string $font */
    public function setFont($font)
    {
        $this->font = $font;
        return $this;
    }

    /** @return string */
    public function getFont()
    {
        return $this->font;
    }

    /** @param int $size */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /** @return int */
    public function getSize()
    {
        return $this->size;
    }

    /** @param int $style */
    public function setStyle($style)
    {
        $this->style = $style;
        return $this;
    }

    /** @return int */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param int $style
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function styleToName($style)
    {
        switch ($style) {
            case self::FONT_NORMAL: return 'normal';
            case self::FONT_BOLD: return 'bold';
            case self::FONT_ITALIC: return 'italic';
        }
        throw new \InvalidArgumentException('Unknown font style: ' . $style);
    }

    /**
     * @param string $name
     * @return int
     */
    public static function nameToStyle($name)
    {
        switch ($name) {
            case 'bold': return self::FONT_BOLD;
            case 'italic': return self::FONT_ITALIC;
        }

        return self::FONT_NORMAL;
    }
}
