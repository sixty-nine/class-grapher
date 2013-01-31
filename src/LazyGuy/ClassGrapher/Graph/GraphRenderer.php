<?php

namespace LazyGuy\ClassGrapher\Graph;

/**
 * Render a Graph
 *
 * @author D. Barsotti <sixtynine.db@gmail.com>
 */
class GraphRenderer implements GraphRendererInterface
{
    /**
     * Render the graph as a DOT string
     * @param array $params A dictionary of parameters
     * @return string The DOT representation of the graph
     */
    public function render(Graph $graph, $params = array())
    {
        $dotString = "digraph G {\n";

        if (array_key_exists('boilerplate', $params)) {
            $dotString .= $params['boilerplate'] . "\n";
        }

        foreach ($graph->getNodes() as $id => $node) {
            if ($node['interface']) {
                $dot = '%s [ label = <%s>, fontname="AvantGarde-BookOblique" ]';
            } else {
                $dot = '%s [ label = <%s> ]';
            }
            $dotString .= sprintf($dot, $id, $node['label']) . "\n";
        }

        foreach ($graph->getEdges() as $edge) {
            list($parent, $child) = $edge;
            $dotString .= sprintf('%s -> %s', $parent, $child) . "\n";
        }

        $dotString .= "\n}\n";

        return $dotString;
    }
}
