<?php

namespace Sven\ForgeCLI\Commands\Workers;

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
        $this->setName('reboot:worker')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the worker to reboot is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the worker to reboot is on.')
            ->addArgument('worker', InputArgument::REQUIRED, 'The id of the worker to reboot.')
            ->setDescription('Reboot one of your workers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $worker = $input->getArgument('worker');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to reboot the worker with id "'.$worker.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting.</info>');

            return;
        }

        $this->forge->restartWorker(
            $input->getArgument('server'), $input->getArgument('site'), $worker, false
        );
    }
}
