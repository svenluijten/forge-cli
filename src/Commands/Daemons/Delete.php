<?php

namespace Sven\ForgeCLI\Commands\Daemons;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Delete extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:daemon')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the daemon is on.')
            ->addArgument('daemon', InputArgument::REQUIRED, 'The id of the daemon to delete.')
            ->setDescription('Delete the given daemon from one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $daemon = $input->getArgument('daemon');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the daemon with id "'.$daemon.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your daemon is safe.</info>');

            return;
        }

        $this->forge->deleteDaemon($input->getArgument('server'), $daemon);
    }
}
