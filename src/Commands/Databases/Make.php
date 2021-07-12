<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand implements NeedsForge
{
    /**
     * @var array
     */
    protected array $optionMap = [
        'user' => 'user',
        'password' => 'password',
        'name' => 'name',
    ];

    public function configure(): void
    {
        $this->setName('database:make')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create the database on.')
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'The username of an (optional) database user to create.', null)
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The password of the database user. Required with "user".', null)
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'The name of the database.', null)
            ->setDescription('Create a new database.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forge->createMysqlDatabase(
            $input->getArgument('server'), $this->fillData($input->getOptions()), false
        );

        return 0;
    }
}
