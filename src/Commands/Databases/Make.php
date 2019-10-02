<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand implements NeedsForge
{
    /**
     * @var array
     */
    protected $optionMap = [
        'user' => 'user',
        'password' => 'password',
        'name' => 'name',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:database')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create the database on.')
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'The username of an (optional) database user to create.', null)
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The password of the database user. Required with "user".', null)
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'The name of the database.', null)
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Create a new database.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->createMysqlDatabase(
            $input->getArgument('server'),
            $this->fillData($input->getOptions()),
            $input->getOption('wait')
        );
    }
}
