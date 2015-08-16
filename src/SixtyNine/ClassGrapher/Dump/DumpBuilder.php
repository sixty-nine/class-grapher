<?php

namespace SixtyNine\ClassGrapher\Dump;

use SixtyNine\ClassGrapher\Model\ItemInterface;
use SixtyNine\ClassGrapher\Model\ObjectTableBuilder;
use SixtyNine\ClassGrapher\Helper\NamespaceHelper;

class DumpBuilder
{
    public function build($dir, $sortClasses = false, $sortNs = false, $sortMethods = false, $noParents = false, $noMethods = false, $noNs = false)
    {
        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build($dir);

        $data = array();

        /** @var \SixtyNine\ClassGrapher\Model\ClassItem $definition */
        foreach ($table as $className => $definition) {
            $parents = $definition->getExtends();
            $parents = array_merge($parents, $definition->getType() === ItemInterface::TYPE_CLASS ? $definition->getImplements() : array());

            if ($noNs) {
                $parents = array_map(function ($value) {
                    return NamespaceHelper::getBasename($value);
                }, $parents);
            }

            $parents = implode(', ', $parents);

            $key = $sortNs ? $className : $definition->getBaseName();

            $data[$key] = array(
                'name' => !$noNs ? $className : $definition->getBaseName(),
                'line' => $definition->getLine(),
                'parents' => !$noParents ? $parents : null,
            );

            if (!$noMethods) {
                $methods = $definition->getMethods();

                if ($sortMethods) {
                    ksort($methods);
                }

                $data[$key]['methods'] = $methods;
            }
        }

        if ($sortClasses || $sortNs) {
            ksort($data);
        }

        return $data;
    }
}
