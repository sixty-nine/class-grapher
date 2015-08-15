<?php

namespace SixtyNine\ClassGrapher\Graph;

/**
 * Interface for graph renderer.
 *
 * @author D. Barsotti <sixtynine.db@gmail.com>
 */
interface GraphRendererInterface
{
    /**
     * Render the graph as a DOT string.
     *
     * @param Graph $graph
     * @param GraphConfig $config
     *
     * @return string The DOT representation of the graph
     */
    public function render(Graph $graph, GraphConfig $config);
}
