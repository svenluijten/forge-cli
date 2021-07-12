<?php

namespace Sven\ForgeCLI\Commands\Servers;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Delete extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('server:delete')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server to delete.')
            ->setDescription('Delete a server.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $server = $input->getArgument('server');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the server with id "'.$server.'"?', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your server is safe.</info>');
        } else {
            $this->forge->deleteServer($server);
        }

        return 0;
    }
}
