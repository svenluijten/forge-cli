<?php

namespace Sven\ForgeCLI\Commands\Certificates;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeLetsEncrypt extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:letsencrypt')
            ->addArgument('server', InputArgument::REQUIRED, 'The id of the server the site is on.')
            ->addArgument('site', InputArgument::REQUIRED, 'The id of the site to make the SSL certificate for.')
            ->addOption('domains', null, InputOption::VALUE_REQUIRED, 'The domain to create an SSL certificate for.')
            ->setDescription('Obtain a new Letsencrypt certificate.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $domains = explode(',',$input->getOption('domains'));

        $certificate = $this->forge->obtainLetsEncryptCertificate(
            $input->getArgument('server'),
            $input->getArgument('site'),
            compact('domains'),
            false
        );
        
        $output->writeln($certificate->id);
    }
}
