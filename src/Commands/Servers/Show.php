<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('server:show')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to show information about.')
            ->setDescription('Show information about one of your servers.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $server = $this->forge->server($input->getArgument('server'));

        $output->writeln([
            '<info>Name:</info>        '.$server->name,
            '<info>IP Address:</info>  '.$server->ipAddress,
            '<info>Size:</info>        '.$server->size,
            '<info>Region:</info>      '.$server->region,
            '<info>PHP version:</info> '.$server->phpVersion,
            '<info>Created:</info>     '.$server->createdAt,
        ]);

        return 0;
    }
}
