<?php

namespace SixtyNine\ClassGrapher\Parser;

class Token
{
    public $type;

    public $data;

    public $line;

    public function __construct($type = 0, $data = '', $line = 1)
    {
        $this->type = $type;
        $this->data = $data;
        $this->line = $line;
    }

    public function __toString()
    {
        return sprintf('Token(%s, %s)', token_name($this->type), $this->data);
    }
}
