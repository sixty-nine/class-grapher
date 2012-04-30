<?php

namespace LazyGuy\Parser\Scanner;

abstract class AbstractScanner implements ScannerInterface
{
    /**
     * @var array
     */
    protected $filters = array();

    private $queue;

    public function __construct()
    {
        $this->queue = new TokenQueue();
    }

    /**
     * @param TokenFilterInterface $filter
     * @return void
     */
    public function addTokenFilter(TokenFilter\TokenFilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @param Token $token
     * @return Token | void
     */
    public function applyFilters(Token $token)
    {
        foreach ($this->filters as $filter) {

            $token = $filter->filter($token);

            if (is_null($token)) {
                break;
            }
        }

        return $token;
    }

    protected function getQueue()
    {
        return $this->queue;
    }

    protected function addToken(Token $token)
    {
        if ($token = $this->applyFilters($token)) {
            $this->debugToken($token);
            $this->queue->add($token);
        }
    }

    protected function debugToken(Token $token)
    {
        $this->debug('  => ' . $token);
    }

    protected function debug($msg)
    {
        //echo sprintf("%s\n", $msg);
    }
}
