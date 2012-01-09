<?php

namespace LazyGuy\ClassGrapher\Tests\Helper;

use LazyGuy\ClassGrapher\Graph\GraphVizBuilder,
    LazyGuy\ClassGrapher\Model\ObjectTableBuilder;

class GraphVizBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $boilerplate = <<<EOF
fontname = "Bitstream Vera Sans"
fontsize = 8
layout = dot
concentrate=true

node [
    fontname = "Bitstream Vera Sans"
    fontsize = 8
    shape = "box"
]

edge [
    dir = "back"
    fontname = "Bitstream Vera Sans"
    fontsize = 8
    arrowtail = "empty"
]

EOF;

        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build(__DIR__ . '/../');

        $builder = new GraphVizBuilder();
        $graph = $builder->build($table);

        $res = $graph->render($boilerplate);
        //echo $res;
    }
}
