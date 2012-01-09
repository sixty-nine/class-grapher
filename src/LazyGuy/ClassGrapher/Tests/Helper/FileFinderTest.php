<?php

namespace LazyGuy\ClassGrapher\Tests\Helper;

use LazyGuy\ClassGrapher\Helper\FileFinder;

class PhpParserTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $dir = realpath(__DIR__ . '/../Fixtures/files');
        
        $expected1 = array(
            $dir . '/File1.php',
            $dir . '/File2.php',
            $dir . '/File3.php',
            $dir . '/File4.php',
            $dir . '/File5.php',
        );
        $expected2  = array(
            $dir . '/subdir/File1.php',
            $dir . '/subdir/File2.php',
        );

        $finder = new FileFinder();

        $this->assertEquals(array_merge($expected1, $expected2), $finder->find($dir));
        $this->assertEquals($expected2, $finder->find($dir . '/subdir'));
        $this->assertEquals($expected1, $finder->find($dir, '*.php', array('subdir')));
        $this->assertEquals(array($dir . '/File1.bla'), $finder->find($dir, '*.bla'));
    }
}
