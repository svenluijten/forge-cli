<?php

namespace Sven\ForgeCLI\Commands\Certificates;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Show extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('show:certificate')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site the SSL certificate is on.')
            ->addArgument('certificate', InputArgument::REQUIRED, 'The id of the SSL certificate to show information about.')
            ->setDescription('Show information about an SSL certificate on the given website.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $certificate = $this->forge->certificate(
            $input->getArgument('server'), $input->getArgument('site'), $input->getArgument('certificate')
        );

        $output->writeln([
            '<info>Domain:</info>            '.$certificate->domain,
            '<info>Status:</info>            '.$certificate->status,
            '<info>Exists:</info>            '.$certificate->existing ? 'Yes' : 'No',
            '<info>Activation Status:</info> '.$certificate->activationStatus,
            '<info>Request Status:</info>    '.$certificate->requestStatus,
            '<info>Created:</info>           '.$certificate->createdAt,
        ]);
    }
}
