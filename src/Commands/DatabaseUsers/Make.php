<?php

namespace Sven\ForgeCLI\Commands\DatabaseUsers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand implements NeedsForge
{
    protected array $optionMap = [
        'username' => 'name',
        'password' => 'password',
        'database' => 'databases',
    ];

    public function configure(): void
    {
        $this->setName('mysql-user:make')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create the MySQL user on.')
            ->addOption('username', null, InputOption::VALUE_REQUIRED, 'The username of the MySQL user to create.', null)
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The password of the database user.', null)
            ->addOption('database', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'The id(s) of the database(s) to give the MySQL user access to.', null)
            ->setDescription('Create a new MySQL user.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forge->createDatabaseUser(
            $input->getArgument('server'), $this->fillData($input->getOptions())
        );

        return 0;
    }
}
