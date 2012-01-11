<?php

namespace LazyGuy\ClassGrapher\Parser;

/**
 * Resolve class names to fully qualified class names
 *
 * @author D. Barsotti <info@dreamcraft.ch>
 */
class ClassResolver
{
    /**
     * @var array(alias => fqn)
     */
    protected $use;

    /**
     * @var string
     */
    protected $curNamespace;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->use = array();
        $this->curNamespace = '';
    }

    /**
     * Add a PHP use to the class resolver. If alias is empty then the last part of the fqn is used as alias.
     * @param string $fqn Full qualified name of the used item
     * @param string $alias The alias to associate the use to. If empty, the last part of $fqn is used
     * @return void
     */
    public function addUse($fqn, $alias = '')
    {
        if ($alias === '') {
            $alias = basename(str_replace('\\', '/', $fqn));
        }

        if (!array_key_exists($alias, $this->use)) {
            $this->use[$alias] = $fqn;
        }
    }

    /**
     * Set the current namespace that will be used to resolve classes without namespace
     * @param string $namespace The current namespace
     * @return void
     */
    public function setNamespace($namespace)
    {
        $this->curNamespace = $namespace;
    }

    /**
     * Resolve a class name to a fully qualified class name in regards to the current namespace
     * and the actual use statements
     * @param string $name The class name to resolve
     * @return string The fully qualified class name
     */
    public function resolve($name)
    {
        $search = $name;
        if (($pos = strpos($name, '\\')) !== false) {
            $search = substr($name, 0, $pos);
        }

        if (array_key_exists($search, $this->use)) {
            if ($pos !== false) {
                return $this->use[$search] . substr($name, $pos);
            }
            return $this->use[$name];
        }
        if (substr($name, 0, 1) === '\\') {
            return $name;
        }

        return $this->curNamespace . '\\' . $name;
    }

}
