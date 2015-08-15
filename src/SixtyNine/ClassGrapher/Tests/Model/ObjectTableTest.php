<?php

namespace SixtyNine\ClassGrapher\Tests\Model;

use SixtyNine\ClassGrapher\Model\ObjectTable;
use SixtyNine\ClassGrapher\Model\ClassItem;

class ObjectTableTest extends \PHPUnit_Framework_TestCase
{
    public function testIteration()
    {
        $ot = new ObjectTable();
        $ot->add(new ClassItem('file1', 'class1'));
        $ot->add(new ClassItem('file1', 'class2'));
        $ot->add(new ClassItem('file1', 'class3'));

        $this->assertEquals(3, $ot->getIterator()->count());

        $idx = 1;
        foreach ($ot as $key => $val) {
            $this->assertEquals('class' . $idx, $key);
            $this->assertEquals(new ClassItem('file1', 'class' . $idx), $val);
            $idx += 1;
        }
    }
}
