<?php

namespace Sven\ForgeCLI\Commands\Certificates;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Activate extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('activate:certificate')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the certificate should be activated on.')
            ->addArgument('certificate', InputArgument::REQUIRED, 'The id of the certificate to activate.')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Activate one of the SSL certificates on the given site.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->activateCertificate(
            $input->getArgument('server'),
            $input->getArgument('site'),
            $input->getArgument('certificate'),
            $input->getOption('wait')
        );
    }
}
