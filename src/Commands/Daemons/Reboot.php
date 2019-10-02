<?php

namespace Sven\ForgeCLI\Commands\Daemons;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Reboot extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('reboot:daemon')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the daemon is on.')
            ->addArgument('daemon', InputArgument::REQUIRED, 'The id of the daemon to reboot.')
            ->addOption('wait', null, InputOption::VALUE_NONE, 'If we should wait for execution')
            ->setDescription('Restart the given daemon on one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $daemon = $input->getArgument('daemon');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to reboot the daemon with id "'.$daemon.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your daemon is safe.</info>');

            return;
        }

        $this->forge->restartDaemon($input->getArgument('server'), $daemon, $input->getOption('wait'));
    }
}
