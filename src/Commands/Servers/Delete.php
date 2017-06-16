<?php

namespace Sven\ForgeCLI\Commands\Servers;

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
        $this->setName('delete:server')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to delete.')
            ->setDescription('Delete a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $server = $input->getArgument('server');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the server with id "'.$server.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your server is safe.</info>');

            return;
        }

        $this->forge->deleteServer($server);
    }
}
