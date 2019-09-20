<?php

namespace Sven\ForgeCLI\Commands\FirewallRules;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Themsaid\Forge\Resources\FirewallRule;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class All extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('list:rules')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list firewall rules for.')
            ->setDescription('Show all firewall rules on a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $rules = $this->forge->firewallRules($input->getArgument('server'));

        $rows = array_map(function (FirewallRule $rule) {
            return [$rule->name, $rule->id, $rule->port, $rule->ipAddress];
        }, $rules);

        $this->table($output, ['Name', 'Id', 'Port', 'IP Address'], $rows);
    }
}
