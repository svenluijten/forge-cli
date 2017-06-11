<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Delete extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:database')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the database is on.')
            ->addArgument('database', InputArgument::REQUIRED, 'The id of the database to delete.')
            ->setDescription('Delete the given database from one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $database = $input->getArgument('database');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the database with id "'.$database.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your database is safe.</info>');

            return;
        }

        $this->forge->deleteMysqlDatabase($input->getArgument('server'), $database);
    }
}
