<?php

namespace Sven\ForgeCLI\Commands\Certificates;

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
        $this->setName('delete:certificate')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server where the site is.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the SSL certificate to delete is on.')
            ->addArgument('certificate', InputArgument::REQUIRED, 'The id of the SSL certificate to delete.')
            ->setDescription('Delete an SSL certificate.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $certificate = $input->getArgument('certificate');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the SSL certificate with id "'.$certificate.'"?', false);

        if (! $helper->ask($input, $output, $question)) {
            $output->writeln('<info>Ok, aborting. Your SSL certificate is safe.</info>');

            return;
        }

        $this->forge->deleteCertificate($input->getArgument('server'), $input->getArgument('site'), $certificate);
    }
}
