<?php

namespace SixtyNine\ClassGrapher\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use Symfony\Component\Process\Process;
use SixtyNine\ClassGrapher\Model\ObjectTableBuilder;
use SixtyNine\ClassGrapher\Graph\GraphBuilder;
use SixtyNine\ClassGrapher\Graph\GraphRenderer;
use SixtyNine\ClassGrapher\Config\ConfigReader;

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
            ->addOption('output', null, InputOption::VALUE_OPTIONAL, 'Output format (text, png, graph)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputType = $input->getOption('output', 'text');
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

        $output->writeln($this->doRun($outputType, $out));
    }

    protected function doRun($output, $out)
    {
        $command = sprintf('echo \'%s\'', $out);

        if ($output === 'png' || $output === 'graph') {
            if (!$this->commandExists('dot')) {
                throw new InvalidArgumentException('The "dot" command is not supported by your system');
            }
            $command .= ' | dot -T png';
        }

        if ($output === 'graph') {
            if (!$this->commandExists('display')) {
                throw new InvalidArgumentException('The "display" command is not supported by your system');
            }
            $command .= ' | display';
        }

        $process = new Process($command);
        $process->setTimeout(3600);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    protected function commandExists($command)
    {
        $process = new Process('which ' . $command);
        $process->run();
        return $process->isSuccessful();
    }
}
