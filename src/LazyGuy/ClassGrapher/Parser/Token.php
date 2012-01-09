<?php

namespace LazyGuy\ClassGrapher\Parser;

class Token
{
    public $type;

    public $data;

    public function __construct($type = 0, $data = '')
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function __toString()
    {
        return sprintf("Token(%s, %s)", token_name($this->type), $this->data);
    }
}