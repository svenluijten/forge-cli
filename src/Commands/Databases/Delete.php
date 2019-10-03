<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Delete extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;
    
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:database')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the database is on.')
            ->addArgument('database', InputArgument::REQUIRED, 'The id of the database to delete.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Delete the given database from one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $database = $input->getArgument('database');

        if (! $this->confirmToProceed("You are going to delete the database with id {$database}.")) {
            return;
        }

        $this->forge->deleteMysqlDatabase($input->getArgument('server'), $database);
    }
}
