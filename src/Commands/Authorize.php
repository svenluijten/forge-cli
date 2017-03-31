<?php

namespace Sven\ForgeCLI\Commands;

use Sven\ForgeCLI\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Authorize extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected $disableApiKeyCheck = true;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('authorize')
            ->setDescription('Set or update the API key used in the commands.')
            ->addArgument('key', InputArgument::REQUIRED, 'The API key found in your Forge account.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function perform(InputInterface $input, OutputInterface $output)
    {
        (new Config)->set('key', $input->getArgument('key'));

        $output->write('Your API key has successfully been set.');
    }
}
