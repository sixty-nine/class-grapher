<?php

namespace LazyGuy\AutoTest\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    LazyGuy\ClassGrapher\Model\ObjectTableBuilder,
    LazyGuy\ClassGrapher\Helper\NamespaceHelper;
use LazyGuy\AutoTest\Helper\AutoTestRenderer;
use LazyGuy\AutoTest\Helper\Twig;

class AutoTestCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('lazyguy:autotest:generate')
            ->setDescription('Generate phpunit tests stubs for a given class')
            ->setHelp('Generate phpunit tests stubs for a given class')
            ->addArgument('path', InputArgument::REQUIRED, 'The php file(s) to generate tests stubs for')
            ->addArgument('output-dir', InputArgument::REQUIRED, 'The directory where the files will be generated')
            ->addOption('phpdoc', null, InputOption::VALUE_OPTIONAL, 'Use phpDoc comments', false)
            ->addOption('stub', null, InputOption::VALUE_OPTIONAL, 'Create method stubs', false)
            ->addOption('ignore-magic', null, InputOption::VALUE_OPTIONAL, 'Ignore magic methods', true)
            ->addOption('force', null, InputOption::VALUE_OPTIONAL, 'Force to overwrite destination files', false)
            ->addOption('dryrun', null, InputOption::VALUE_OPTIONAL, 'Simulate the execution', false)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('path');
        $outputDir = $input->getArgument('output-dir');
        $phpdoc = $input->getOption('phpdoc');
        $methodStub = $input->getOption('stub');
        $ignoreMagic = $input->getOption('ignore-magic');
        $force = $input->getOption('force');
        $dryrun = $input->getOption('dryrun');

        if (!is_dir($outputDir) || !is_writable($outputDir)) {
            throw new \InvalidArgumentException("The output directory does not exist or is not writable");
        }

        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build($file, true);

        $builder = new AutoTestRenderer();
        $files = $builder->render($table, $phpdoc, $methodStub, $ignoreMagic);

        foreach ($files as $name => $content) {

            // Create destination dir if needed
            $destDir = $outputDir . '/' . dirname($name);
            if (!is_dir($destDir)) {
                $output->writeln(sprintf('Create directory <comment>%s</comment>', $destDir));
                if (!$dryrun) {
                    mkdir($destDir, 0777, true);
                }
            }

            // Skip existing destination files if needed
            $destFile = $outputDir . '/' . $name;
            if (!$force && file_exists($destFile)) {
                $output->writeln(sprintf("Skipping <comment>%s</comment>", $name));
                continue;
            }

            // Generate the file
            $output->writeln(sprintf("Generate <comment>%s</comment>", $destFile));
            if (!$dryrun) {
                file_put_contents($destFile, $content);
            }
        }


    }

}
