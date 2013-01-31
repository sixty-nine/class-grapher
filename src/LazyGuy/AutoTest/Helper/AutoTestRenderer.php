<?php

namespace LazyGuy\AutoTest\Helper;

use LazyGuy\ClassGrapher\Model\ObjectTable;
use LazyGuy\ClassGrapher\Model\ClassItem;
use LazyGuy\ClassGrapher\Helper\_Namespace;
use LazyGuy\ClassGrapher\Helper\NamespaceHelper;
use LazyGuy\ClassGrapher\Model\ItemInterface;

class AutoTestRenderer
{
    protected function generateTestFileName(ItemInterface $class)
    {
        $ns = new _Namespace($class->getNamespace());

        return sprintf(
            '%s/Tests/%s/%sTest.php',
            $ns->parent()->getDirName(),
            $ns->slice(2, 1)->getDirName(''),
            $class->getBaseName()
        );
    }

    public function render(ObjectTable $table, $phpdoc = false, $methodStub = false, $ignoreMagic = true)
    {
        $result = array();

        foreach ($table as $class) {

            // generate tests only for classes
            if (! $class instanceof ClassItem) {
                continue;
            }

            $filename = $this->generateTestFileName($class);

            // Capitalize the first letter of the methods
            $methods = array();
            foreach ($class->getMethods() as $method) {
                // skip magic methods if needed
                if (!$ignoreMagic  || substr($method, 0, 2) !== '__') {
                    $methods[] = ucfirst($method);
                }
            }

            // skip classes with no methods to test
            if (empty($methods)) {
                continue;
            }

            $namespace = NamespaceHelper::insertNamespace($class->getNamespace(), 'Tests', -2);

            $twig = Twig::getTwig(__DIR__ . '/../Resources/templates');
            $result[$filename] = $twig->render(
                'AutoTest.php.twig',
                array(
                    'namespace' => $namespace,
                    'className' => $class->getBaseName(),
                    'fullClassName' => $class->getName(),
                    'methods' => $methods,
                    'phpdoc' => $phpdoc,
                    'methodstub' => $methodStub,
                )
            );

        }

        return $result;
    }
}
