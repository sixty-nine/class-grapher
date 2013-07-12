<?php

namespace SixtyNine\PhpParse\Scanner\Context;

class DefaultScannerContext extends ScannerContext
{
    public function __construct()
    {
        $this->addWhitespace(" ");
        $this->addWhitespace("\t");

        $this->addStringDelimiter('\'');
        $this->addStringDelimiter('"');

        $this->addLineCommentDelimiter('//');

        $this->addBlockCommentDelimiter('/*', '*/');

        $symbols = array(
            '<', '>', '+', '*', '%', '&', '/', '(', ')', '=', '?', '#', '|', '!', '~',
            '[', ']', '{', '}', '$', ',', ';', ':', '.', '-', '_', '\\',
        );
        foreach($symbols as $symbol) {
            $this->addSymbol($symbol);
        }
    }
}
