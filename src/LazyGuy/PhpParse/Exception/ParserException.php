<?php

namespace LazyGuy\PhpParse\Exception;

use LazyGuy\PhpParse\Scanner\TokenQueue,
    LazyGuy\PhpParse\Scanner\Token As Token;

class ParserException extends \Exception
{
    public function __construct(TokenQueue $queue, $msg)
    {
        $token = $queue->peek();
        $msg = sprintf("PARSER ERROR: %s. Current token is [%s, '%s'] at line %s, column %s", $msg, Token::getTypeName($token->getType()), $token->getData(), $token->getLine(), $token->getRow());

        // construct a lookup of the next tokens
        $lookup = '';
        for($i = 1; $i <= 5; $i++) {
            if ($queue->isEof()) {
                break;
            }
            $token = $queue->get();
            $lookup .= $token->getData() . ' ';
        }
        $msg .= "\nBuffer lookup: \"$lookup\"";

        parent::__construct($msg);
    }
}
