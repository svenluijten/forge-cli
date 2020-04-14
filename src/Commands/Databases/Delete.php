<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Delete extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('database:delete')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the database is on.')
            ->addArgument('database', InputArgument::REQUIRED, 'The id of the database to delete.')
            ->setDescription('Delete the given database from one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $database = $input->getArgument('database');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the database with id "'.$database.'"?', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your database is safe.</info>');
        } else {
            $this->forge->deleteMysqlDatabase($input->getArgument('server'), $database);
        }

        return 0;
    }
}
