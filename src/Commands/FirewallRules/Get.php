<?php

namespace Sven\ForgeCLI\Commands\FirewallRules;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Get extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('show:rule')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the firewall rule to show information about is on.')
            ->addArgument('rule', InputArgument::REQUIRED, 'The id of the firewall rule to show information about.')
            ->setDescription('Show information about the given firewall rule.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $rule = $this->forge->firewallRule($input->getArgument('server'), $input->getArgument('rule'));

        $output->writeln([
            '<info>Name:</info>        '.$rule->name,
            '<info>IP Address:</info>  '.$rule->ipAddress,
            '<info>Port:</info>        '.$rule->port,
            '<info>Status:</info>      '.$rule->status,
            '<info>Created:</info>     '.$rule->createdAt,
        ]);
    }
}
