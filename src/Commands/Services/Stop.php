<?php

namespace Sven\ForgeCLI\Commands\Services;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Stop extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('stop:service')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to stop the service on.')
            ->addArgument('service', InputArgument::REQUIRED, 'The service to stop. Can be either "nginx", "mysql" or "postgres".')
            ->setDescription('Stop a service on a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $service = strtolower($input->getArgument('service'));
        $server = $input->getArgument('server');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to stop '.$service.' on the server with id '.$server.'?', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting.</info>');

            return;
        }

        switch ($service) {
            case 'mysql':
                $this->forge->stopMysql($server);
                break;
            case 'nginx':
                $this->forge->stopNginx($server);
                break;
            case 'postgres':
                $this->forge->stopPostgres($server);
                break;
        }
    }
}
