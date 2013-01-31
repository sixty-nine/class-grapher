<?php

namespace LazyGuy\AutoTest\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    LazyGuy\ClassGrapher\Model\ObjectTableBuilder,
    LazyGuy\ClassGrapher\Helper\NamespaceHelper;

class AutoTestCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('lazyguy:autotest')
            ->setDescription('Generate phpunit tests stubs for a given class')
            ->setHelp('Generate phpunit tests stubs for a given class')
            ->addArgument('file', InputArgument::REQUIRED, 'The php file for which tests stubs will be generated')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');

        $otBuilder = new ObjectTableBuilder();
        $table = $otBuilder->build($file);

        // TODO: nonono..
        require_once '/home/dev/ClassGrapher/vendor/twig/twig/lib/Twig/Autoloader.php';
        \Twig_Autoloader::register();

        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../Resources/templates');
        $twig = new \Twig_Environment($loader);

        foreach ($table as $class) {

            // Capitalize the first letter of the methods
            $methods = array();
            foreach ($class->getMethods() as $method) {
                $methods[] = strtoupper(substr($method, 0, 1)) . substr($method, 1);
            }

            $namespace = NamespaceHelper::insertNamespace($class->getNamespace(), 'Tests', -2);

            echo $twig->render(
                'AutoTest.php.twig',
                array(
                    'namespace' => $namespace,
                    'className' => $class->getBaseName(),
                    'fullClassName' => $class->getName(),
                    'methods' => $methods,
                )
            );

        }

    }

}
