<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

$console = new Application('My Silex Application', 'n/a');
$console->getDefinition()->addOption(new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev'));

$console->register('server:run')
    ->setDefinition(array(
        new InputArgument('address', InputArgument::OPTIONAL, 'Address:port', 'localhost:8000'),
        new InputOption('docroot', 'd', InputOption::VALUE_REQUIRED, 'Document root', 'web/'),
        new InputOption('router', 'r', InputOption::VALUE_REQUIRED, 'Path to custom router script'),
    ))
    ->setDescription('Initiates a PHP server')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $router = __DIR__.'/../config/router.php';

        $output->writeln(sprintf("Server running on <info>%s</info>\n", $input->getArgument('address')));

        $builder = new ProcessBuilder(array(PHP_BINARY, '-S', $input->getArgument('address'), $router));
        $builder->setWorkingDirectory($input->getOption('docroot'));
        $builder->setTimeout(null);
        $builder->getProcess()->run(function ($type, $buffer) use ($output) {
            if (OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $output->write($buffer);
            }
        });
    });

return $console;
