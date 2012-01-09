<?php

namespace LazyGuy\ClassGrapher\Tests\Model;

use LazyGuy\ClassGrapher\Model\ObjectTableBuilder;

class ObjectTableBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $builder = new ObjectTableBuilder();
        $table = $builder->build(__DIR__ . '/../');

        //var_dump($table);
    }
}
