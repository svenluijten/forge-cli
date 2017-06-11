<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Sven\ForgeCLI\Commands\BaseCommand;
use Themsaid\Forge\Resources\MysqlDatabase;
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
        $this->setName('list:databases')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list the databases for.')
            ->setDescription('Show all databases a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $rows = array_map(function (MysqlDatabase $database) {
            return [$database->id, $database->name, $database->status, $database->createdAt];
        }, $this->forge->mysqlDatabases($input->getArgument('server')));

        $this->table($output, ['Id', 'Name', 'Status', 'Created'], $rows);
    }
}
