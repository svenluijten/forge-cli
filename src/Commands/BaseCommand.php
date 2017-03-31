<?php

namespace Sven\ForgeCLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return mixed
     */
    abstract public function perform(InputInterface $input, OutputInterface $output);

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Check API key

        $this->perform($input, $output);
    }
}
