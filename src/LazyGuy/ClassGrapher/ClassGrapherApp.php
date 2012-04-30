<?php

namespace LazyGuy\ClassGrapher;

use Symfony\Component\Console\Application;

class ClassGrapherApp extends Application
{
    public function __construct() {

        parent::__construct('Welcome to LazyGuy\'s Class Grapher', '1.0');

        $commands = array(
            new Command\BuildGraphCommand(),
            new Command\AutoTestCommand(),
        );

        $this->addCommands($commands);
    }
}