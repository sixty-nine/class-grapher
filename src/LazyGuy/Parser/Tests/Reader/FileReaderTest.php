<?php

namespace LazyGuy\Parser\Tests\Reader;

use LazyGuy\Parser\Reader\FileReader;

class FileReaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->filename = __DIR__ . '/../Fixtures/files/TestFile.txt';
        $this->reader = new FileReader($this->filename);

        $this->lines = array(
            'This is a test file...',
            '',
            '...containing dummy content.',
            ''
        );

        $this->content = file_get_contents($this->filename);
        $this->chars = array_merge(
            preg_split('//', $this->lines[0], -1, PREG_SPLIT_NO_EMPTY),
            array("\n", "\n"),
            preg_split('//', $this->lines[2], -1, PREG_SPLIT_NO_EMPTY),
            array("\n", "\n")
        );
    }

    public function test__construct()
    {
//        $this->assertInstanceOf('\LazyGuy\Parser\Reader\FileReader', $this->reader);
//        $this->assertAttributeEquals($this->filename, 'fileName', $this->reader);
//        $this->assertAttributeEquals(0, 'curLine', $this->reader);
//        $this->assertAttributeEquals(0, 'curRow', $this->reader);
//        $this->assertAttributeEquals(file_get_contents($this->filename), 'content', $this->reader);
//        $this->assertAttributeEquals($this->lines, 'lines', $this->reader);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test__construct_fileNotFound()
    {
        $reader = new FileReader('unexisting_file');
    }

    public function testGetFileName()
    {
        $this->assertEquals($this->filename, $this->reader->getFileName());
    }

    public function testGetBuffer()
    {
        $this->assertEquals(file_get_contents($this->filename) . $this->reader->getEofMarker(), $this->reader->getBuffer());
    }

//    public function testGetNextChar()
//    {
//        $curLine = 1;
//        $curCol = 1;
//
//        for ($i = 0; $i < count($this->chars); $i++) {
//
//            $this->assertEquals($curLine, $this->reader->getCurrentLine());
//            $this->assertEquals($curCol, $this->reader->getCurrentColumn());
//
//            // Assert isEof is false before the end of the file
//            $this->assertFalse($this->reader->isEof());
//
//            // Assert isEol is true at end of the lines
//            $peek = $this->reader->peekNextChar();
//            if ($peek === "\n") {
//                $this->assertTrue($this->reader->isEol());
//                $curLine++;
//                $curCol = 1;
//            } else {
//                $curCol++;
//            }
//
//            // Assert the next character is the expected one
//            $next = $this->reader->getNextChar();
//            $this->assertEquals($peek, $next);
//            $this->assertEquals(
//                $this->chars[$i],
//                $next,
//                sprintf("Character mismatch at position %s, expected '%s', found '%s'", $i, $this->chars[$i], $next)
//            );
//        }
//
//        // Check it's the end of the file
//        $this->assertFalse($this->reader->peekNextChar());
//        $this->assertFalse($this->reader->getNextChar());
//        $this->assertTrue($this->reader->isEof());
//    }

}
