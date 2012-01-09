<?php

namespace LazyGuy\ClassGrapher\Tests\Model;

use LazyGuy\ClassGrapher\Model\ObjectTable,
    LazyGuy\ClassGrapher\Model\ClassItem;

class ObjectTableTest extends \PHPUnit_Framework_TestCase
{
    public function testIteration()
    {
        $ot = new ObjectTable();
        $ot->add(new ClassItem('class1'));
        $ot->add(new ClassItem('class2'));
        $ot->add(new ClassItem('class3'));

        $this->assertEquals(3, $ot->getIterator()->count());

        $idx = 1;
        foreach ($ot as $key => $val) {
            $this->assertEquals('class' . $idx, $key);
            $this->assertEquals(new ClassItem('class' . $idx), $val);
            $idx += 1;
        }
    }
}
