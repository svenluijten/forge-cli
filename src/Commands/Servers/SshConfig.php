<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SshConfig extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('server:ssh-config')
            ->addOption('with-sites', null, InputOption::VALUE_NONE, 'Adds specific sites, too. Useful if you are using isolation.')
            ->setDescription('Generate an SSH configuration file for servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $servers = $this->forge->servers();

        foreach ($servers as $server) {
            $output->writeln($this->outputTemplate($server->name, $server->ipAddress, $server->sshPort));
            $output->writeln('');

            if ($input->getOption('with-sites')) {
                $sites = $this->forge->sites($server->id);

                foreach ($sites as $site) {
                    $output->writeln($this->outputTemplate("{$server->name}:{$site->name}", $server->ipAddress, $server->sshPort,
                        $site->username ?? 'forge', $site->name));
                    $output->writeln('');
                }
            }
        }

        return 0;
    }

    public function outputTemplate($name, $ip, $port = 22, $username = 'forge', $directory = null)
    {
        return [
            "Host {$name}",
            "    Hostname {$ip}",
            "    Port {$port}",
            "    User {$username}",
        ] + ($directory ? [
            "    RequestTTY yes",
            "    RemoteCommand cd {$directory}; exec \$SHELL;",
        ] : []);
    }
}
