<?php

namespace Sven\ForgeCLI\Commands\DatabaseUsers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Update extends BaseCommand implements NeedsForge
{
    protected array $optionMap = [
        'database' => 'databases',
    ];

    public function configure(): void
    {
        $this->setName('mysql-user:update')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the MySQL user is on.')
            ->addArgument('user', InputArgument::REQUIRED, 'The id of the MySQL user to update.')
            ->addOption('database', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'The id(s) of the database(s) to give the MySQL user access to.')
            ->setDescription('Update the given MySQL user.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $payload = $this->fillData($input->getOptions());

        $this->forge->updateDatabaseUser(
            $input->getArgument('server'), $input->getArgument('user'), $payload
        );

        return 0;
    }
}
