<?php

namespace Sven\ForgeCLI\Commands\Daemons;

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
        'command' => 'command',
        'user' => 'user',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:daemon')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create the daemon on.')
            ->addOption('command', null, InputOption::VALUE_REQUIRED, 'The command to run.')
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'The user to run the command as.', 'forge')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Create and start a new daemon.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->forge->createDaemon(
            $input->getArgument('server'),
            $this->fillData($input->getOptions()),
            $input->getOption('wait')
        );
    }
}
