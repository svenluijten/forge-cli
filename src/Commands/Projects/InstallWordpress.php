<?php

namespace Sven\ForgeCLI\Commands\Projects;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallWordpress extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('install:wordpress')
             ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
             ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to install the WordPress project on.')
             ->addOption('database', null, InputOption::VALUE_REQUIRED, 'The name of the database to use.')
             ->addOption('user', null, InputOption::VALUE_REQUIRED, 'The name of the user to create.')
             ->setDescription('Install a new WordPress project on a site.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->installWordPress(
            $input->getArgument('server'),
            $input->getArgument('site'),
            $this->fillData($input->getOptions())
        );
    }
}
