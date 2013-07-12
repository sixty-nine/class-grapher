<?php

namespace SixtyNine\ClassGrapher\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption;

use SixtyNine\ClassGrapher\Graph\GraphBuilder,
    SixtyNine\ClassGrapher\Model\ObjectTableBuilder,
    SixtyNine\ClassGrapher\Graph\GraphRenderer;

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
            ->addOption('noedges', null, InputOption::VALUE_NONE, 'Don\'t show the edges')
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
                'use-groups' => $input->hasParameterOption('--groups'),
                'use-edges' => !$input->hasParameterOption('--noedges'),
            )
        );

        $output->writeln($out);
    }

}