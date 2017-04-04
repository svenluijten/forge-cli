<?php

namespace Sven\ForgeCLI\Commands\Daemons;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Reboot extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('reboot:daemon')
            ->setDescription('Delete the given daemon from one of your servers.')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the daemon is on.')
            ->addArgument('daemon', InputArgument::REQUIRED, 'The id of the daemon to reboot.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $daemon = $input->getArgument('daemon');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to reboot the daemon with id "'.$daemon.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your daemon is safe.</info>');

            return;
        }

        $this->forge->restartDaemon($input->getArgument('server'), $daemon);
    }
}
