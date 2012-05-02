<?php

namespace LazyGuy\PhpParse\Scanner\Context;

use LazyGuy\PhpParse\Scanner\TokenFilter;

class DefaultScannerContextWithoutSpacesAndComments extends DefaultScannerContext
{
    public function __construct()
    {
        parent::__construct();

        $this->addTokenFilter(new TokenFilter\NoNewlinesFilter());
        $this->addTokenFilter(new TokenFilter\NoWhitespacesFilter());
        $this->addTokenFilter(new TokenFilter\NoCommentsFilter());
    }
    
}
