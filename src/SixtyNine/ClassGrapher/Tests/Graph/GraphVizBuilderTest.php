<?php

namespace SixtyNine\ClassGrapher\Tests\Helper;

use SixtyNine\ClassGrapher\Graph\GraphBuilder;
use SixtyNine\ClassGrapher\Graph\GraphConfig;
use SixtyNine\ClassGrapher\Graph\GraphFontConfig;
use SixtyNine\ClassGrapher\Model\ObjectTableBuilder;
use SixtyNine\ClassGrapher\Graph\GraphRenderer;

class GraphVizBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $expected = file_get_contents(__DIR__ . '/../Fixtures/expected-graph.gv');

        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build(__DIR__ . '/../Fixtures');

        $builder = new GraphBuilder();
        $graph = $builder->build($table);

        $renderer = new GraphRenderer();
        $config = new GraphConfig();
        $config
            ->getInterfaceFont()
            ->setColor('grey40')
            ->setStyle(GraphFontConfig::FONT_ITALIC | GraphFontConfig::FONT_BOLD)
        ;
        $config
            ->getBaseFont()
            ->setStyle(GraphFontConfig::FONT_BOLD)
            ->setColor('red')
        ;        $res = $renderer->render($graph, $config);
        $this->assertEquals($expected, $res);
    }
}
