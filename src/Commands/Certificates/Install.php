<?php

namespace Sven\ForgeCLI\Commands\Certificates;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Install extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('certificate:install')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server where the site is.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the SSL certificate to delete is on.')
            ->addArgument('certificate', InputArgument::REQUIRED, 'The id of the SSL certificate to delete.')
            ->setDescription('Install the given SSL certificate on a site.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forge->installCertificate(
            $input->getArgument('server'), $input->getArgument('site'), $input->getArgument('certificate')
        );

        return 0;
    }
}
