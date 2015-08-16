<?php

namespace SixtyNine\ClassGrapher\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use SixtyNine\AutoTest\Helper\Twig;
use SixtyNine\ClassGrapher\Dump\DumpBuilder;

class DumpObjectTableCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('dump3')
            ->setDescription('Dump the object table')
            ->setHelp('Generate a list of classes and methods in text format')
            ->addArgument('dir', InputArgument::REQUIRED, '')
            ->addOption('html', null, InputOption::VALUE_NONE, 'HTML output')
            ->addOption('sort-classes', null, InputOption::VALUE_NONE, 'Sort by classes names')
            ->addOption('sort-methods', null, InputOption::VALUE_NONE, 'Sort by method names')
            ->addOption('sort-ns', null, InputOption::VALUE_NONE, 'Sort by namespaces names')
            ->addOption('no-methods', null, InputOption::VALUE_NONE, 'Don\'t show method names')
            ->addOption('no-parents', null, InputOption::VALUE_NONE, 'Don\'t show classes parents')
            ->addOption('no-ns', null, InputOption::VALUE_NONE, 'Don\'t show namespaces')
            ->addOption('classes', null, InputOption::VALUE_NONE, 'Preset: Show class names (--no-methods, --no-parents)')
            ->addOption('short', null, InputOption::VALUE_NONE, 'Preset: Show class names without namespaces (--no-methods, --no-parents, --no-ns, --sort-classes)')
            ->addOption('inherit', null, InputOption::VALUE_NONE, 'Preset: Show inheritance (--no-methods)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');
        $sortClasses = $input->getOption('short') || (bool) $input->getOption('sort-classes');
        $sortNs = (bool) $input->getOption('sort-ns');
        $sortMethods = $input->getOption('sort-methods');
        $noMethods = $input->getOption('classes') || $input->getOption('inherit') || $input->getOption('short') || $input->getOption('no-methods');
        $noParents = $input->getOption('classes') || $input->getOption('short') || $input->getOption('no-parents');
        $noNs = $input->getOption('short') || $input->getOption('no-ns');
        $html = $input->getOption('html');

        $dumpBuilder = new DumpBuilder($dir);
        $data = $dumpBuilder->build($dir, $sortClasses, $sortNs, $sortMethods, $noParents, $noMethods, $noNs);

        $twig = Twig::getTwig(__DIR__ . '/../Resources/templates');
        $out = $twig->render(
            $html ? 'ObjectTable.html.twig' : 'ObjectTable.txt.twig',
            array(
                'table' => $data,
            )
        );

        $output->writeln($out);
    }
}
