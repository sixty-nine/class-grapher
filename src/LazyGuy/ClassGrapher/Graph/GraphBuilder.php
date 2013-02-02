<?php

namespace LazyGuy\ClassGrapher\Graph;

use LazyGuy\ClassGrapher\Model\ObjectTable,
    LazyGuy\ClassGrapher\Model\ItemInterface,
    LazyGuy\ClassGrapher\Model\ClassItem,
    LazyGuy\ClassGrapher\Model\InterfaceItem,
    LazyGuy\ClassGrapher\Helper\NamespaceHelper;
use LazyGuy\ClassGrapher\Helper\NamespaceTreeItem;
use LazyGuy\ClassGrapher\Helper\NamespaceTree;

/**
 * Build a simple GraphViz inheritance graph from an object table
 *
 * @author D. Barsotti <sixtynine.db@gmail.com>
 */
class GraphBuilder
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
     * @return \LazyGuy\ClassGrapher\Graph\Graph The inheritance graph
     */
    public function build(ObjectTable $table)
    {
        $this->nodes = array();
        $this->counter = 0;
        $this->graph = new Graph();
        $nsTree = new NamespaceTree();

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

            $nsTree->addClass($item->getName());
        }

        $nsTree->pruneAndMerge();
        $this->buildGroups($nsTree->getTree());

        return $this->graph;
    }

    protected function buildGroups(NamespaceTreeItem $node)
    {
        $counter = 1;
        foreach ($node->children as $name => $child) {
            $nodes = array();
            foreach ($child->data as $className) {
                $nodes[] = $this->nodes[md5($name . '\\' . $className)];
            }
            $this->graph->addGroup('cluster_' . $counter, str_replace('\\', '/', $name), $nodes);
            $counter++;
        }

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
            $label = NamespaceHelper::getBasename($name);

            $this->graph->addNode($id, $label, $interface);

            $this->counter += 1;
        }
    }
}