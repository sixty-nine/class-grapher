<?php

namespace SixtyNine\PhpParse\Parser;

use SixtyNine\PhpParse\Scanner\GenericToken;
use SixtyNine\PhpParse\Scanner\TokenQueue;
use SixtyNine\PhpParse\Exception\ParserException;
use SixtyNine\PhpParse\Helper\AbstractDebuggable;

/**
 * Abstract base class for parsers with debugging capabilities.
 *
 * It implements helper functions for parsers:
 *
 *      - checkToken            - check if the next token matches
 *      - expectToken           - expect the next token to match
 *      - checkAndExpectToken   - check and then expect the next token to match
 */
abstract class AbstractParser extends AbstractDebuggable implements ParserInterface
{
    /**
     * The token queue
     * @var \SixtyNine\PhpParse\Scanner\TokenQueue
     */
    protected $tokenQueue;

    /**
     * @param \SixtyNine\PhpParse\Scanner\TokenQueue $tokenQueue
     */
    public function __construct(TokenQueue $tokenQueue)
    {
        $this->tokenQueue = $tokenQueue;
    }

    /**
     * Check the next token without consuming it and return true if it matches the given type and data.
     * If the data is not provided (equal to null) then only the token type is checked.
     * Return false otherwise.
     * 
     * @param int $type The expected token type
     * @param null|string $data The expected data or null
     * @return bool
     */
    protected function checkToken($type, $data = null)
    {
        if ($this->tokenQueue->isEof()) {
            return false;
        }

        $token = $this->tokenQueue->peek();

        if ($token->getType() !== $type) {
            return false;
        }

        if ($data && $token->getData() !== $data) {
            return false;
        }

        return true;
    }

    /**
     * Check if the next token matches the expected type and data. If it does, then consume and return it,
     * otherwise throw an exception.
     *
     * @throws \SixtyNine\PhpParse\Exception\ParserException
     * @param int $type The expected token type
     * @param null|string $data The expected token data or null
     * @return \SixtyNine\PhpParse\Scanner\Token
     */
    protected function expectToken($type, $data = null)
    {
        $token = $this->tokenQueue->peek();

        if (!$this->checkToken($type, $data)) {
            throw new ParserException($this->tokenQueue, sprintf("Expected token [%s, '%s']", GenericToken::getTypeName($type), $data));
        }

        $this->tokenQueue->next();

        return $token;
    }

    /**
     * Check if the next token matches the expected type and data. If it does, then consume it, otherwise
     * return false.
     *
     * @param int $type The expected token type
     * @param null|string $data The expected token data or null
     * @return bool|\SixtyNine\PhpParse\Scanner\Token
     */
    protected function checkAndExpectToken($type, $data = null)
    {
        if ($this->checkToken($type, $data)) {
            $token = $this->tokenQueue->peek();
            $this->tokenQueue->next();
            return $token;
        }

        return false;
    }
}
