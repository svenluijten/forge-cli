<?php

namespace Sven\ForgeCLI\Servers;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class All extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('list:servers')
            ->setDescription('Show all servers associated with your account.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        //
    }
}
