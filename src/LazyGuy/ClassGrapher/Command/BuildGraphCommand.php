<?php

namespace LazyGuy\ClassGrapher\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption;

use LazyGuy\ClassGrapher\Graph\GraphBuilder,
    LazyGuy\ClassGrapher\Model\ObjectTableBuilder,
    LazyGuy\ClassGrapher\Graph\GraphRenderer;

class BuildGraphCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('graph')
            ->setDescription('Generate a class diagram in GraphViz format')
            ->setHelp('Generate a class diagram in GraphViz format')
            ->addArgument('dir', InputArgument::REQUIRED, '')
            ->addOption('groups', null, InputOption::VALUE_OPTIONAL, 'Group by namespace', false)
            ->addOption('edges', null, InputOption::VALUE_OPTIONAL, 'Show edges', true)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');

        $otBuilder = new ObjectTableBuilder();
        $graphBuilder = new GraphBuilder();
        $renderer = new GraphRenderer();

        $table = $otBuilder->build($dir);
        $graph = $graphBuilder->build($table);

        $out = $renderer->render(
            $graph,
            array(
                'use-groups' => $input->getOption('groups'),
                'use-edges' => $input->getOption('edges'),
            )
        );

        $output->writeln($out);
    }

}