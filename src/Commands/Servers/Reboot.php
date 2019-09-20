<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Reboot extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('reboot:server')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to reboot.')
            ->setDescription('Reboot one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $server = $input->getArgument('server');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to reboot the server with id "'.$server.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting.</info>');

            return;
        }

        $this->forge->rebootServer($server);
    }
}
