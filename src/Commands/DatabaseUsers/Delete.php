<?php

namespace Sven\ForgeCLI\Commands\DatabaseUsers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Delete extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('mysql-user:delete')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the MySQL user is on.')
            ->addArgument('user', InputArgument::REQUIRED, 'The id of the MySQL user to delete.')
            ->setDescription('Delete the given MySQL user from one of your servers.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $input->getArgument('user');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the MySQL user with id "'.$user.'"?', false);

        if ($helper->ask($input, $output, $question)) {
            $this->forge->deleteDatabaseUser($input->getArgument('server'), $user);
        } else {
            $output->writeln('<info>Ok, aborting. Your MySQL user is safe.</info>');
        }

        return 0;
    }
}
