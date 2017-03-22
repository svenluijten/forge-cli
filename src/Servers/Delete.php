<?php

namespace Sven\ForgeCLI\Servers;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Delete extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('delete:server')
            ->setDescription('Delete a server.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        //
    }
}
