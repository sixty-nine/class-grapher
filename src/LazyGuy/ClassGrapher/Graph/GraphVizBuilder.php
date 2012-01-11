<?php

namespace LazyGuy\ClassGrapher\Graph;

use LazyGuy\ClassGrapher\Model\ObjectTable,
    LazyGuy\ClassGrapher\Model\ItemInterface,
    LazyGuy\ClassGrapher\Model\ClassItem,
    LazyGuy\ClassGrapher\Model\InterfaceItem;

/**
 * Build a simple GraphViz inheritance graph from an object table
 *
 * @author D. Barsotti <info@dreamcraft.ch>
 */
class GraphVizBuilder
{
    /**
     * Lookup table for classes and interfaces already inserted in the graph
     * @var array(hash => id)
     */
    protected $nodes;

    /**
     * Counter used to generate the nodes IDs
     * @var int
     */
    protected $counter;

    /**
     * @var \LazyGuy\ClassGrapher\Model\ObjectTable
     */
    protected $graph;

    /**
     * Build the inheritance graph
     * @param \LazyGuy\ClassGrapher\Model\ObjectTable $table The object table
     * @return \LazyGuy\ClassGrapher\Graph\GraphViz The inheritance graph
     */
    public function build(ObjectTable $table)
    {
        $this->nodes = array();
        $this->counter = 0;
        $this->graph = new GraphViz();

        foreach($table as $item)
        {
            $nodeHash = md5($item->getName());

            if ($item instanceof ClassItem) {

                $this->addNode($item->getName());

                // Generate interfaces nodes and edges
                foreach ($item->getImplements() as $interfaceName) {
                    $interfaceHash = md5($interfaceName);
                    $this->addNode($interfaceName, true);
                    $this->graph->addEdge($this->nodes[$interfaceHash], $this->nodes[$nodeHash]);
                }
            } else {

                $this->addNode($item->getName(), true);
            }

            // Generate parent node and edge
            foreach($item->getExtends() as $parentName) {
                $parentHash = md5($parentName);
                $this->addNode($parentName);
                $this->graph->addEdge($this->nodes[$parentHash], $this->nodes[$nodeHash]);
            }

        }

        return $this->graph;
    }

    /**
     * Add a node to the graph if it does not already exist
     * @param $name The name of the node
     * @param bool $interface True if interfaces style must be applied to the node
     * @return void
     */
    protected function addNode($name, $interface = false)
    {
        $hash = md5($name);

        if (!array_key_exists($hash, $this->nodes)) {

            $id = 'node_' . $this->counter;
            $this->nodes[$hash] = $id;
            $label = basename(str_replace('\\', '/', $name));

            // TODO: implement a different node style when $interface is true

            $this->graph->addNode($id, $label);

            $this->counter += 1;
        }
    }
}