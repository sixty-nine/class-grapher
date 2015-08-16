<?php

namespace SixtyNine\ClassGrapher\Command;

use SixtyNine\ClassGrapher\Config\ConfigReader;
use SixtyNine\ClassGrapher\Graph\GraphConfig;
use SixtyNine\ClassGrapher\Graph\GraphFontConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use SixtyNine\ClassGrapher\Graph\GraphBuilder;
use SixtyNine\ClassGrapher\Model\ObjectTableBuilder;
use SixtyNine\ClassGrapher\Graph\GraphRenderer;

class BuildGraphCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('graph')
            ->setDescription('Generate a class diagram in GraphViz format')
            ->setHelp('Generate a class diagram in GraphViz format')
            ->addArgument('dir', InputArgument::REQUIRED, '')
            ->addOption('groups', null, InputOption::VALUE_NONE, 'Group by namespace')
            ->addOption('no-edges', null, InputOption::VALUE_NONE, 'Don\'t show the edges')
            ->addOption('no-orphans', null, InputOption::VALUE_NONE, 'Don\'t show orphan nodes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');

        $otBuilder = new ObjectTableBuilder();
        $graphBuilder = new GraphBuilder();
        $renderer = new GraphRenderer();

        $table = $otBuilder->build($dir);
        $graph = $graphBuilder->build($table, $input->hasParameterOption('--no-orphans'));

        $configReader = new ConfigReader();
        $config = $configReader->read(__DIR__ . '/../Resources/config/config.yml');

        $config
            ->setShowGroups($input->hasParameterOption('--groups'))
            ->setShowEdges(!$input->hasParameterOption('--no-edges'));

        $out = $renderer->render($graph, $config);

        $output->writeln($out);
    }
}
