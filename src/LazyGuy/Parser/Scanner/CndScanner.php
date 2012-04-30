<?php

namespace LazyGuy\Parser\Scanner;

use LazyGuy\Parser\Reader\ReaderInterface,
    LazyGuy\Parser\Scanner\Token;

class CndScanner extends GenericScanner
{
    public function __construct()
    {
        // Deactivate the contruction of tokens for newlines and white spaces
        parent::__construct(false, false);
    }
}
