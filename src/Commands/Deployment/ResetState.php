<?php

namespace Sven\ForgeCLI\Commands\Deployment;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetState extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('reset-deploy-state')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site you want to reset the deployment state of.')
            ->setDescription('Reset the deployment state of the given site.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forge->resetDeploymentState(
            $input->getArgument('server'), $input->getArgument('site')
        );

        return 0;
    }
}
