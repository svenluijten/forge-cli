<?php

namespace Sven\ForgeCLI\Commands\FirewallRules;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('rule:show')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the firewall rule to show information about is on.')
            ->addArgument('rule', InputArgument::REQUIRED, 'The id of the firewall rule to show information about.')
            ->setDescription('Show information about the given firewall rule.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $rule = $this->forge->firewallRule($input->getArgument('server'), $input->getArgument('rule'));

        $output->writeln([
            '<info>Name:</info>        '.$rule->name,
            '<info>IP Address:</info>  '.$rule->ipAddress,
            '<info>Port:</info>        '.$rule->port,
            '<info>Status:</info>      '.$rule->status,
            '<info>Created:</info>     '.$rule->createdAt,
        ]);

        return 0;
    }
}
