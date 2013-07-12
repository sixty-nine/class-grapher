<?php

namespace LazyGuy\ClassGrapher\Tests\Helper;

use LazyGuy\ClassGrapher\Graph\GraphBuilder,
    LazyGuy\ClassGrapher\Model\ObjectTableBuilder;
use LazyGuy\ClassGrapher\Graph\GraphRenderer;

class GraphVizBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $expected = <<<EOF
digraph G {

    fontname = "AvantGarde-Book"
    fontsize = 8
    layout = dot
    concentrate=true
    ranksep = 0.1

    node [
        fontname = "AvantGarde-Book"
        fontsize = 8
        shape = "box"
        style = rounded
        height = 0.25
    ]

    edge [
        dir = "back"
        arrowtail = "empty"
    ]

    node_0 [ label = <MyInterface1>, fontname="AvantGarde-BookOblique", color=grey75 ]
    node_1 [ label = <MyInterface2>, fontname="AvantGarde-BookOblique", color=grey75 ]
    node_2 [ label = <MyInterface3>, fontname="AvantGarde-BookOblique", color=grey75 ]
    node_3 [ label = <MyClass1> ]
    node_4 [ label = <GraphViz> ]
    node_5 [ label = <MyClass2> ]
    node_6 [ label = <MyClass3> ]
    node_7 [ label = <MyClass4> ]
    node_8 [ label = <MyClass5> ]

    node_0 -> node_1
    node_0 -> node_2
    node_1 -> node_2
    node_4 -> node_3
    node_0 -> node_5
    node_0 -> node_6
    node_4 -> node_6
    node_0 -> node_7
    node_1 -> node_7



}

EOF;

        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build(__DIR__ . '/../Fixtures');

        $builder = new GraphBuilder();
        $graph = $builder->build($table);

        $renderer = new GraphRenderer();
        $res = $renderer->render($graph, array('use-edges' => true));
        $this->assertEquals($expected, $res);
    }
}
