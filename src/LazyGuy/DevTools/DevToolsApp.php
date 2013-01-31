<?php

namespace LazyGuy\DevTools;

use Symfony\Component\Console\Application;

class DevToolsApp extends Application
{
    public function __construct() {

        parent::__construct('Welcome to LazyGuy\'s Dev Tools', '1.0');

        $commands = array(
            new \LazyGuy\ClassGrapher\Command\BuildGraphCommand(),
            new \LazyGuy\AutoTest\Command\AutoTestCommand(),
        );

        $this->addCommands($commands);
    }
}