<?php

namespace Sven\ForgeCLI\Commands\Certificates;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Install extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('install:certificate')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server where the site is.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the SSL certificate to install is on.')
            ->addArgument('certificate', InputArgument::REQUIRED, 'The id of the SSL certificate to install.')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Install the given SSL certificate on a site.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->installCertificate(
            $input->getArgument('server'),
            $input->getArgument('site'),
            $input->getArgument('certificate'),
            [],
            $input->getOption('wait')
        );
    }
}
