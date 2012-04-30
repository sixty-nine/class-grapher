<?php

namespace LazyGuy\ClassGrapher\Helper;

class NamespaceHelper {

    public static function getBasename($namespace)
    {
        return basename(str_replace('\\', '/', $namespace));
    }

    public static function getNamespace($namespace)
    {
        $ns = dirname(str_replace('\\', '/', $namespace));
        if ($ns && $ns !== '.') {
            return str_replace('/', '\\', $ns);
        }
        return '';
    }

    /**
     * Insert the namespace $name at $position in the given $namespace.
     *
     *    - Position can be 0 or positive:
     *
     *      in this case the new namespace is inserted at the given position,
     *      zero being the start of the namespace.
     *
     *      Example:
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4')     --> 'NS4\\NS1\\NS2\\NS3'
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4', 1)  --> 'NS1\\NS4\\NS2\\NS3'
     *          ...
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4', 3)  --> 'NS1\\NS2\\NS3\\NS4'
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4', 4)  --> 'NS1\\NS2\\NS3\\NS4'
     *
     *    - Position can be negative:
     *
     *      in this case the position is calculated from the end of the string.
     *
     *      Example:
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4', -1)  --> 'NS1\\NS2\\NS3\\NS4'
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4', -2)  --> 'NS1\\NS2\\NS4\\NS3'
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4', -3)  --> 'NS1\\NS4\\NS2\\NS3'
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4', -4)  --> 'NS4\\NS1\\NS2\\NS3'
     *          insertNamespace('NS1\\NS2\\NS3', 'NS4', -5)  --> 'NS4\\NS1\\NS2\\NS3'
     *
     * @see \LazyGuy\ClassGrapher\Tests\Helper\NamespaceHelperTest
     * @static
     * @param $namespace
     * @param $name
     * @param int $position
     * @return void
     */
    public static function insertNamespace($namespace, $name, $position = 0)
    {
        $parts = explode('\\', $namespace);

        // Fix the WTF with negative positions with too big amplitude
        if (count($parts) + $position + 1 < 0) {
            $position = 0;
        }

        if ($position === 0) {
            // Position = 0
            $parts = array_merge(
                array($name),
                $parts
            );
        } elseif ($position < 0) {
            // Negative position
            $parts = array_merge(
                array_slice($parts, 0, count($parts) + $position + 1),
                array($name),
                array_slice($parts, count($parts) + $position + 1)
            );
        } else {
            // Positive position
            $parts = array_merge(
                array_slice($parts, 0, $position),
                array($name),
                array_slice($parts, $position)
            );
        }

        return implode('\\', $parts);
     }
}
