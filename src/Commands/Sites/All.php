<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Themsaid\Forge\Resources\Site;
use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class All extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('list:sites')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the sites for.')
            ->setDescription('Show all sites installed on a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $this->table($output, ['Id', 'Name', 'Type', 'Repository', 'Branch'], array_map(function (Site $site) {
            return [$site->id, $site->name, $site->projectType, $site->repository ?: '-', $site->repositoryBranch ?: '-'];
        }, $this->forge->sites($input->getArgument('server'))));
    }
}
