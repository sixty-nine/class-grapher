<?php

namespace LazyGuy\ClassGrapher\Model;

use LazyGuy\ClassGrapher\Helper\FileFinder,
    LazyGuy\ClassGrapher\Parser\ClassResolver,
    LazyGuy\ClassGrapher\Parser\Parser,
    LazyGuy\ClassGrapher\Parser\Tokenizer;

class ObjectTableBuilder
{
    public function build($dirName, $ignoreTests = true)
    {
        $ignore = array();
        if ($ignoreTests) {
            $ignore[] = 'Tests';
        }

        $objectTable = new ObjectTable();
        $classResolver = new ClassResolver();

        $finder = new FileFinder();
        $files = $finder->find(realpath($dirName), '*.php', $ignore);

        foreach ($files as $file) {
            $parser = new Parser(new Tokenizer($file), $classResolver, $objectTable);
            $parser->parse();
        }

        return $objectTable;
    }

}