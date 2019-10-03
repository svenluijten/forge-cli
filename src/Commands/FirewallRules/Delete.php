<?php

namespace Sven\ForgeCLI\Commands\FirewallRules;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Delete extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:rule')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the firewall rule to delete is on.')
            ->addArgument('rule', InputArgument::REQUIRED, 'The id of the firewall rule to delete.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction')
            ->setDescription('Delete a firewall rule.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $rule = $input->getArgument('rule');
        
        if (! $this->confirmToProceed("You are going to delete the rule with id {$rule}.")) {
            return;
        }

        $this->forge->deleteFirewallRule($input->getArgument('server'), $rule);
    }
}
