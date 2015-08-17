<?php

namespace SixtyNine\DevTools;

use Symfony\Component\Console\Application;

class DevToolsApp extends Application
{
    public function __construct() {

        parent::__construct('Welcome to SixtyNine\'s Dev Tools', '1.0');

        $commands = array(
            new \SixtyNine\ClassGrapher\Command\BuildGraphCommand(),
            new \SixtyNine\ClassGrapher\Command\DumpObjectTableCommand(),
        );

        $this->addCommands($commands);
    }
}