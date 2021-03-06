<?php

namespace SixtyNine\ClassGrapher\Graph;

use SixtyNine\ClassGrapher\Model\ClassItem;
use SixtyNine\ClassGrapher\Model\ItemInterface;
use SixtyNine\ClassGrapher\Model\ObjectTable;
use SixtyNine\ClassGrapher\Helper\NamespaceHelper;
use SixtyNine\ClassGrapher\Helper\NamespaceTreeItem;
use SixtyNine\ClassGrapher\Helper\NamespaceTree;

/**
 * Build a simple GraphViz inheritance graph from an object table.
 *
 * @author D. Barsotti <sixtynine.db@gmail.com>
 */
class GraphBuilder
{
    /**
     * Lookup table for classes and interfaces already inserted in the graph.
     *
     * @var array(hash => id)
     */
    protected $nodes;

    /**
     * Counter used to generate the nodes IDs.
     *
     * @var int
     */
    protected $counter;

    /** @var int */
    protected $clusterCounter;

    /** @var Graph */
    protected $graph;

    /**
     * Build the inheritance graph.
     *
     * @param \SixtyNine\ClassGrapher\Model\ObjectTable $table The object table
     *
     * @return \SixtyNine\ClassGrapher\Graph\Graph The inheritance graph
     */
    public function build(ObjectTable $table, $removeOrphans = false)
    {
        $this->nodes = array();
        $this->counter = 0;
        $this->clusterCounter = 0;
        $this->graph = new Graph();
        $nsTree = new NamespaceTree();

        /** @var ClassItem $item */
        foreach ($table as $item) {
            $nodeHash = md5($item->getName());

            if ($item->getType() === ItemInterface::TYPE_CLASS) {
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
            foreach ($item->getExtends() as $parentName) {
                $parentHash = md5($parentName);
                $this->addNode($parentName);
                $this->graph->addEdge($this->nodes[$parentHash], $this->nodes[$nodeHash]);
            }

            $nsTree->addClass($item->getName());
        }

        $nsTree->pruneAndMerge();

        if ($removeOrphans) {
            $this->removeOrphans();
        }

        $this->buildGroups($nsTree->getTree());

        return $this->graph;
    }

    protected function buildGroups(NamespaceTreeItem $node, $curNamespace = '', $parentCluster = '')
    {
        foreach ($node->children as $name => $child) {
            $nodes = array();
            $namespace = ($curNamespace === '' ? '' : $curNamespace . '\\') . $name;
            $cluster = 'cluster_' . $this->clusterCounter;

            foreach ($child->data as $className) {
                $hash = md5($namespace . '\\' . $className);
                if (array_key_exists($hash, $this->nodes)) {
                    $nodes[] = $this->nodes[$hash];
                }
            }
            $this->graph->addGroup($cluster, str_replace('\\', '/', $name), $nodes, $parentCluster);
            ++$this->clusterCounter;

            $this->buildGroups($child, $namespace, $cluster);
        }
    }

    /**
     * Add a node to the graph if it does not already exist.
     *
     * @param string $name      The name of the node
     * @param bool   $interface True if interfaces style must be applied to the node
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

    protected function removeOrphans()
    {
        foreach ($this->graph->getNodes() as $key => $data) {

            $isOrphan = true;

            foreach ($this->graph->getEdges() as $edge) {
                if ($key === $edge[0] || $key === $edge[1]) {
                    $isOrphan = false;
                    break;
                }
            }

            if ($isOrphan) {
                $this->graph->removeNode($key);
                $hash = $this->getNodeKey($key);
                if ($hash) {
                    unset($this->nodes[$hash]);
                }
            }
        }
    }

    protected function getNodeKey($nodeName)
    {
        foreach ($this->nodes as $key => $value) {
            if ($value === $nodeName) {
                return $key;
            }
        }
        return false;
    }
}
