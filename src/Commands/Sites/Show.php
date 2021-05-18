<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('site:show')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to show information about.')
            ->setDescription('Show information about a site on a specified server.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $site = $this->forge->site(
            $input->getArgument('server'), $input->getArgument('site')
        );

        $output->writeln([
            '<info>Name:</info>            '.$site->name,
            '<info>Repository info:</info> '.$site->repository.' @ '.$site->repositoryBranch,
            '<info>Directory:</info>       '.$site->directory,
            '<info>Quick deploy:</info>    '.($site->quickDeploy ? 'On' : 'Off'),
            '<info>Status:</info>          '.$site->status,
            '<info>Project type:</info>    '.$site->projectType,
            '<info>Created:</info>         '.$site->createdAt,
        ]);

        return 0;
    }
}
