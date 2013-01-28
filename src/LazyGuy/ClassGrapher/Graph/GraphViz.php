<?php

namespace LazyGuy\ClassGrapher\Graph;

/**
 * Generate simple GraphViz graphs
 *
 * @author D. Barsotti <info@dreamcraft.ch>
 */
class GraphViz
{
    /**
     * @var array
     */
    protected $nodes;

    /**
     * @var array
     */
    protected $edges;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nodes = array();
        $this->edges = array();
    }

    /**
     * Add a node to the graph
     * @param $id The unique ID of the node
     * @param $label The label of the node
     * @return void
     */
    public function addNode($id, $label, $isInterface = false)
    {
        if (!array_key_exists($id, $this->nodes)) {
            $this->nodes[$id] = array('label' => $label, 'interface' => $isInterface);
        }
    }

    /**
     * Add a edge parent --> child in the graph
     * @throws \InvalidArgumentException
     * @param $parent The source node of the edge
     * @param $child The destination node of the edge
     * @return void
     */
    public function addEdge($parent, $child)
    {
        if (!array_key_exists($parent, $this->nodes)) {
            throw new \InvalidArgumentException("Parent node '$parent' does not exist");
        }

        if (!array_key_exists($child, $this->nodes)) {
            throw new \InvalidArgumentException("Child node '$child' does not exist");
        }

        $this->edges[] = array($parent, $child);
    }

    /**
     * Render the graph as a DOT string
     * @param string $boilerplate The boiler plate code that must be added to the graph.
     * @return string The DOT representation of the graph
     */
    public function render($boilerplate = '')
    {
        $graph = "digraph G {\n$boilerplate\n";

        foreach ($this->nodes as $id => $node) {
            if ($node['interface']) {
                $dot = '%s [ label = <%s>, fontname="AvantGarde-BookOblique" ]';
            } else {
                $dot = '%s [ label = <%s> ]';
            }
            $graph .= sprintf($dot, $id, $node['label']) . "\n";
        }

        foreach ($this->edges as $edge) {
            list($parent, $child) = $edge;
            $graph .= sprintf('%s -> %s', $parent, $child) . "\n";
        }

        $graph .= "\n}\n";

        return $graph;
    }
}