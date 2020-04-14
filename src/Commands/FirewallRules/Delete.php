<?php

namespace Sven\ForgeCLI\Commands\FirewallRules;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Delete extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('rule:delete')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the firewall rule to delete is on.')
            ->addArgument('rule', InputArgument::REQUIRED, 'The id of the firewall rule to delete.')
            ->setDescription('Delete a firewall rule.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $rule = $input->getArgument('rule');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the rule with id "'.$rule.'"?', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your firewall rule is safe.</info>');
        } else {
            $this->forge->deleteFirewallRule($input->getArgument('server'), $rule);
        }

        return 0;
    }
}
