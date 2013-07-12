<?php

namespace SixtyNine\PhpParse\Scanner;

use SixtyNine\PhpParse\Reader\ReaderInterface;

interface ScannerInterface
{
    /**
     * @abstract
     * @param \SixtyNine\PhpParse\Reader\ReaderInterface $reader
     * @return TokenQueue
     */
    function scan(ReaderInterface $reader);

    /**
     * @abstract
     * @param Token $token
     * @return Token | void
     */
    function applyFilters(Token $token);

}
