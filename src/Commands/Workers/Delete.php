<?php

namespace Sven\ForgeCLI\Commands\Workers;

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
        $this->setName('delete:worker')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the database is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the worker to delete is on.')
            ->addArgument('worker', InputArgument::REQUIRED, 'The id of the worker to delete.')
            ->setDescription('Delete the given worker.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $worker = $input->getArgument('worker');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the worker with id "'.$worker.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your worker is safe.</info>');

            return;
        }

        $this->forge->deleteWorker(
            $input->getArgument('server'), $input->getArgument('site'), $worker
        );
    }
}
