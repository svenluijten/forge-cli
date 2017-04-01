<?php

namespace Sven\ForgeCLI\Commands\Sites;

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
        $this->setName('delete:site')
            ->setDescription('Delete a site.')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server where the site is.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to delete.');
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $site = $input->getArgument('site');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the site with id "'.$site.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your site is safe.</info>');

            return;
        }

        $this->forge->deleteSite($input->getArgument('server'), $site);
    }
}
