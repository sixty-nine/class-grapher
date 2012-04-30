<?php

namespace LazyGuy\ClassGrapher\Tests\Fixtures;

class MyClass5
{
    public function myPublicFunction() {}
    public function myPublicFunctionWithParams(MyClass5 $myself, $somethingElse) {}
    protected function myProtectedFunction() {}
    private function myPrivateFunction() {}
}
