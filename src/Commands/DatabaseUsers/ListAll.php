<?php

namespace Sven\ForgeCLI\Commands\DatabaseUsers;

use Laravel\Forge\Resources\DatabaseUser;
use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAll extends BaseCommand implements NeedsForge
{
    protected function configure()
    {
        $this->setName('mysql-user:list')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the MySQL users for.')
            ->setDescription('Show all MySQL users on a server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rows = array_map(function (DatabaseUser $user) {
            return [$user->id, $user->name, $user->status, $user->createdAt];
        }, $this->forge->databaseUsers($input->getArgument('server')));

        $this->table($output, ['Id', 'Name', 'Status', 'Created'], $rows);

        return 0;
    }
}
