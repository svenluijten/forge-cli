<?php

namespace Sven\ForgeCLI\Commands\Daemons;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Make extends BaseCommand implements NeedsForge
{
    protected array $optionMap = [
        'command' => 'command',
        'user' => 'user',
    ];

    public function configure(): void
    {
        $this->setName('daemon:make')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to create the daemon on.')
            ->addOption('command', null, InputOption::VALUE_REQUIRED, 'The command to run.')
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'The user to run the command as.', 'forge')
            ->setDescription('Create and start a new daemon.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forge->createDaemon(
            $input->getArgument('server'), $this->fillData($input->getOptions())
        );

        return 0;
    }
}
