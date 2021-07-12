<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Laravel\Forge\Resources\Site;
use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAll extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('site:list')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the sites for.')
            ->setDescription('Show all sites installed on a server.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->table($output, ['Id', 'Name', 'Type', 'Repository', 'Branch'], array_map(function (Site $site) {
            return [$site->id, $site->name, $site->projectType, $site->repository ?: '-', $site->repositoryBranch ?: '-'];
        }, $this->forge->sites($input->getArgument('server'))));

        return 0;
    }
}
