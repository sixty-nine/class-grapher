<?php

namespace SixtyNine\ClassGrapher\Model;

use SixtyNine\ClassGrapher\Helper\FileFinder;
use SixtyNine\ClassGrapher\Parser\ClassResolver;
use SixtyNine\ClassGrapher\Parser\Parser;
use SixtyNine\ClassGrapher\Parser\Tokenizer;

class ObjectTableBuilder
{
    /**
     * @var \SixtyNine\ClassGrapher\Model\ObjectTable
     */
    protected $objectTable;

    /**
     * @param $dirName
     * @param bool $ignoreTests
     *
     * @return ObjectTable
     *
     * @throws \InvalidArgumentException
     */
    public function build($dirName, $ignoreTests = true)
    {
        $ignore = array();
        if ($ignoreTests) {
            $ignore[] = 'Tests';
        }

        $this->objectTable = new ObjectTable();
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
            $parser = new Parser(new Tokenizer($file), $classResolver, $this);
            $parser->parse();
        }

        return $this->objectTable;
    }

    public function addClass($file, $line, $name, $extends = array(), $implements = array())
    {
        $item = new ClassItem($file, $line, $name, $extends, $implements);
        $this->objectTable->add($item);

        return $item;
    }

    public function addInterface($file, $line, $name, $extends = array())
    {
        $item = new InterfaceItem($file, $line, $name, $extends);
        $this->objectTable->add($item);

        return $item;
    }
}
