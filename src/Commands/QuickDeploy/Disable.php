<?php

namespace Sven\ForgeCLI\Commands\QuickDeploy;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Disable extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('quickdeploy:disable')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to disable quick deployment for.')
            ->setDescription('Disable quick deployment on the given site.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forge->disableQuickDeploy(
            $input->getArgument('server'), $input->getArgument('site')
        );

        return 0;
    }
}
