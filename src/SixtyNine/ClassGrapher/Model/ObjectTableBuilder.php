<?php

namespace SixtyNine\ClassGrapher\Model;

use SixtyNine\ClassGrapher\Helper\FileFinder;
use SixtyNine\ClassGrapher\Parser\ClassResolver;
use SixtyNine\ClassGrapher\Parser\Parser;
use SixtyNine\ClassGrapher\Parser\Tokenizer;

class ObjectTableBuilder
{
    /**
     * @param $dirName
     * @param bool $ignoreTests
     * @return ObjectTable
     * @throws \InvalidArgumentException
     */
    public function build($dirName, $ignoreTests = true)
    {
        $ignore = array();
        if ($ignoreTests) {
            $ignore[] = 'Tests';
        }

        $objectTable = new ObjectTable();
        $classResolver = new ClassResolver();

        if (is_dir($dirName)) {
            $finder = new FileFinder();
            $files = $finder->find(realpath($dirName), '*.php', $ignore);
        } elseif (file_exists($dirName)) {
            $files = array($dirName);
        } else {
            throw new \InvalidArgumentException("File or directory not found '$dirName'");
        }

        foreach ($files as $file) {
            $parser = new Parser(new Tokenizer($file), $classResolver, $objectTable);
            $parser->parse();
        }

        return $objectTable;
    }

}