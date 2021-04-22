<?php

namespace Sven\ForgeCLI\Commands\Env;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Get extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('env:get')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to get the .env file for.')
            ->setDescription('Show the .env file.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $env = $this->forge->siteEnvironmentFile(
            $input->getArgument('server'), $input->getArgument('site')
        );

        $output->writeln($env);

        return 0;
    }
}
