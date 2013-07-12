<?php

namespace SixtyNine\PhpParse\Scanner\Context;

use SixtyNine\PhpParse\Scanner\TokenFilter;

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
