<?php

namespace Sven\ForgeCLI\Commands\DeployScript;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Get extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('deploy-script:get')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to get the deployment script of.')
            ->setDescription('Output the deployment script used for the given site.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $script = $this->forge->siteDeploymentScript(
            $input->getArgument('server'), $input->getArgument('site')
        );

        $output->writeln($script);

        return 0;
    }
}
