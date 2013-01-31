<?php

namespace LazyGuy\ClassGrapher\Graph;

/**
 * Generate simple GraphViz graphs
 *
 * @author D. Barsotti <sixtynine.db@gmail.com>
 */
class Graph
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

    public function getNodes()
    {
        return $this->nodes;
    }

    public function getEdges()
    {
        return $this->edges;
    }
}