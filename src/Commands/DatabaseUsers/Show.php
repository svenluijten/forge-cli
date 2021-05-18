<?php

namespace Sven\ForgeCLI\Commands\DatabaseUsers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends BaseCommand implements NeedsForge
{
    protected function configure()
    {
        $this->setName('mysql-user:show')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the MySQL user is on.')
            ->addArgument('user', InputArgument::REQUIRED, 'The id of the MySQL user to show information about.')
            ->setDescription('Show information about the given MySQL user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->forge->databaseUser(
            $input->getArgument('server'), $input->getArgument('user')
        );

        $output->writeln([
            '<info>Status:</info>  '.$user->status,
            '<info>Name:</info>    '.$user->name,
            '<info>Created:</info> '.$user->createdAt,
        ]);

        return 0;
    }
}
