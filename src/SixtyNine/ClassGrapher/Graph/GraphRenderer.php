<?php

namespace SixtyNine\ClassGrapher\Graph;

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
//        die(var_dump($graph->getGroups()));
        $twig = \SixtyNine\AutoTest\Helper\Twig::getTwig(__DIR__ . '/../Resources/templates');
        return $twig->render(
            'Graph.dot.twig',
            array(
                'baseFont' => 'AvantGarde-Book',
                'classFont' => 'AvantGarde-Book',
                'interfaceFont' => 'AvantGarde-BookOblique',
                'nodes' => $graph->getNodes(),
                'edges' => $graph->getEdges(),
                'groups' => $graph->getGroups(),
                'useedges' => isset($params['use-edges']) && $params['use-edges'],
                'usegroups' => isset($params['use-groups']) && $params['use-groups'],
            )
        );
    }
}
