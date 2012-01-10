<?php

namespace LazyGuy\ClassGrapher\Tests\Helper;

use LazyGuy\ClassGrapher\Graph\GraphVizBuilder,
    LazyGuy\ClassGrapher\Model\ObjectTableBuilder;

class GraphVizBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $expected = <<<EOF
digraph G {
SOME_BOILER_PLATE_CODE
node_0 [ label = "MyInterface1" ]
node_1 [ label = "MyInterface2" ]
node_2 [ label = "MyClass1" ]
node_3 [ label = "GraphViz" ]
node_4 [ label = "MyClass2" ]
node_5 [ label = "MyClass3" ]
node_6 [ label = "MyClass4" ]
node_3 -> node_2
node_0 -> node_4
node_3 -> node_5
node_0 -> node_5
node_0 -> node_6
node_1 -> node_6

}

EOF;

        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build(__DIR__ . '/../Fixtures');

        $builder = new GraphVizBuilder();
        $graph = $builder->build($table);

        $res = $graph->render('SOME_BOILER_PLATE_CODE');
        $this->assertEquals($expected, $res);
    }
}
