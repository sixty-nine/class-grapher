<?php

namespace SixtyNine\ClassGrapher\Command;

use SixtyNine\ClassGrapher\Model\ItemInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

use SixtyNine\ClassGrapher\Model\ObjectTableBuilder;
use SixtyNine\ClassGrapher\Model\ClassItem;
use SixtyNine\ClassGrapher\Helper\NamespaceHelper;
use SixtyNine\AutoTest\Helper\Twig;

class DumpObjectTableCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('dump')
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
        $sortClasses = $input->getOption('short') || (bool)$input->getOption('sort-classes');
        $sortNs = (bool)$input->getOption('sort-ns');
        $sortMethods = $input->getOption('sort-methods');
        $noMethods = $input->getOption('classes') || $input->getOption('inherit') || $input->getOption('short') || $input->getOption('no-methods');
        $noParents = $input->getOption('classes') || $input->getOption('short') || $input->getOption('no-parents');
        $noNs = $input->getOption('short') || $input->getOption('no-ns');
        $html = $input->getOption('html');

        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build($dir);

        $data = array();

        /** @var \SixtyNine\ClassGrapher\Model\ClassItem $definition */
        foreach ($table as $className => $definition) {

            $parents = $definition->getExtends();
            $parents = array_merge($parents, $definition->getType() === ItemInterface::TYPE_CLASS ? $definition->getImplements() : array());

            if ($noNs) {
                $parents = array_map(function ($value) {
                    return NamespaceHelper::getBasename($value);
                }, $parents);
            }

            $parents = implode(', ', $parents);

            $key = $sortNs ? $className : $definition->getBaseName();

            $data[$key] = array(
                'name' => !$noNs ? $className : $definition->getBaseName(),
                'parents' => !$noParents ? $parents : null,
            );

            if (!$noMethods) {
                $methods = $definition->getMethods();

                if ($sortMethods) {
                    asort($methods);
                }

                $data[$key]['methods'] = $methods;
            }
        }

        if ($sortClasses || $sortNs) {
            ksort($data);
        }

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
