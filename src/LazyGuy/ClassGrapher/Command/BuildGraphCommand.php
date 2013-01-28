<?php

namespace LazyGuy\ClassGrapher\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    LazyGuy\ClassGrapher\Graph\GraphVizBuilder,
    LazyGuy\ClassGrapher\Model\ObjectTableBuilder;

class BuildGraphCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('lazyguy:graph')
            ->setDescription('')
            ->setHelp('')
            ->addArgument('dir', InputArgument::REQUIRED, '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');

        $boilerplate = <<<EOF
fontname = "AvantGarde-Book"
fontsize = 8
layout = dot
concentrate=true

node [
    fontname = "AvantGarde-Book"
    fontsize = 8
    shape = "box"
]

edge [
    dir = "back"
    arrowtail = "empty"
]

EOF;

        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build($dir);

        $builder = new GraphVizBuilder();
        $graph = $builder->build($table);

        $out = $graph->render($boilerplate);

        $output->writeln($out);
    }

}