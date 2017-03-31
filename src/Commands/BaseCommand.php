<?php

namespace Sven\ForgeCLI\Commands;

use Sven\ForgeCLI\Config;
use Themsaid\Forge\Forge;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends Command
{
    /**
     * @var bool
     */
    protected $needsForge = true;

    /**
     * @var Forge
     */
    protected $forge;

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
        if (!$this->needsForge) {
            $this->perform($input, $output);

            return;
        }

        $key = (new Config)->get('key');

        $this->forge = new Forge($key);

        $this->perform($input, $output);
    }
}
