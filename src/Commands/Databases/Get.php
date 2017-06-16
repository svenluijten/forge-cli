<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Get extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('show:database')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to the database is running on.')
            ->addArgument('database', InputArgument::REQUIRED, 'The id of the database to show information about.')
            ->setDescription('Show information about the given database.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $database = $this->forge->mysqlDatabase(
            $input->getArgument('server'), $input->getArgument('database')
        );

        $output->writeln([
            '<info>Status:</info>  '.$database->status,
            '<info>Name:</info>    '.$database->name,
            '<info>Created:</info> '.$database->createdAt,
        ]);
    }
}
