<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Laravel\Forge\Resources\Database;
use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAll extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('database:list')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the databases for.')
            ->setDescription('Show all databases a server.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = array_map(function (Database $database) {
            return [$database->id, $database->name, $database->status, $database->createdAt];
        }, $this->forge->mysqlDatabases($input->getArgument('server')));

        $this->table($output, ['Id', 'Name', 'Status', 'Created'], $rows);

        return 0;
    }
}
