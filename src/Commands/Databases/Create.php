<?php

namespace Sven\ForgeCLI\Commands\Databases;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends BaseCommand
{
    /**
     * @var array
     */
    protected $optionMap = [
        'user' => 'user',
        'password' => 'password',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('create:database')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create the database on.')
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'The username of an (optional) database user to create.', null)
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The password of the database user. Required with "user".', null)
            ->setDescription('Create a new database.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $this->forge->createMysqlDatabase(
            $input->getArgument('server'), $this->fillData($input->getOptions()), false
        );
    }
}
