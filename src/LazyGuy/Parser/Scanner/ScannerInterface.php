<?php

namespace LazyGuy\Parser\Scanner;

use LazyGuy\Parser\Reader\ReaderInterface;

interface ScannerInterface
{
    /**
     * @abstract
     * @param \LazyGuy\Parser\Reader\ReaderInterface $reader
     * @return TokenQueue
     */
    function scan(ReaderInterface $reader);

    /**
     * @abstract
     * @param TokenFilter\TokenFilterInterface $filter
     * @return void
     */
    function addTokenFilter(TokenFilter\TokenFilterInterface $filter);

    /**
     * @abstract
     * @param Token $token
     * @return Token | void
     */
    function applyFilters(Token $token);

}
