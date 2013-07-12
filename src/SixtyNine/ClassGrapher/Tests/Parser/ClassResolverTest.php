<?php

namespace SixtyNine\ClassGrapher\Tests\Parser;

use SixtyNine\ClassGrapher\Parser\ClassResolver;

class ClassResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testAddUse()
    {
        $fqn = 'Dreamcraft\\ParserBundle\\Parser\\ClassResolver';

        $resolver = new ClassResolver();
        $resolver->addUse($fqn, 'MyClass');
        $this->assertAttributeEquals(array('MyClass' => $fqn), 'aliases', $resolver);

        $resolver->addUse($fqn);
        $this->assertAttributeEquals(array('ClassResolver' => $fqn), 'use', $resolver);
        $this->assertAttributeEquals(array('MyClass' => $fqn), 'aliases', $resolver);

        $resolver->addUse($fqn);
        $this->assertAttributeEquals(array('ClassResolver' => $fqn), 'use', $resolver);
        $this->assertAttributeEquals(array('MyClass' => $fqn), 'aliases', $resolver);
    }

    public function testResolve()
    {
        $fqn = 'Dreamcraft\\ParserBundle\\Parser\\ClassResolver';

        $resolver = new ClassResolver();
        $resolver->addUse($fqn);
        $resolver->addUse($fqn, 'MyClass');

        $this->assertEquals('\\foobar', $resolver->resolve('foobar'));
        $this->assertEquals('\\foobar', $resolver->resolve('\\foobar'));

        $this->assertEquals($fqn, $resolver->resolve('ClassResolver'));
        $this->assertEquals($fqn . '\\foobar', $resolver->resolve('ClassResolver\\foobar'));
        $this->assertEquals($fqn . '\\foo\\bar', $resolver->resolve('ClassResolver\\foo\\bar'));

        $this->assertEquals($fqn, $resolver->resolve('MyClass'));
        $this->assertEquals($fqn . '\\foobar', $resolver->resolve('MyClass\\foobar'));
        $this->assertEquals($fqn . '\\foo\\bar', $resolver->resolve('MyClass\\foo\\bar'));
    }
}
