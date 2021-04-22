<?php

namespace Sven\ForgeCLI\Commands\FirewallRules;

use Laravel\Forge\Resources\FirewallRule;
use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAll extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('rule:list')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to list firewall rules for.')
            ->setDescription('Show all firewall rules on a server.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $rules = $this->forge->firewallRules($input->getArgument('server'));

        $rows = array_map(function (FirewallRule $rule) {
            return [$rule->name, $rule->id, $rule->port, $rule->ipAddress];
        }, $rules);

        $this->table($output, ['Name', 'Id', 'Port', 'IP Address'], $rows);

        return 0;
    }
}
