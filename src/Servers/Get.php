<?php

namespace Sven\ForgeCLI\Servers;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Get extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('show:server')
            ->setDescription('Show information about one of your servers.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        //
    }
}
