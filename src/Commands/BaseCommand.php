<?php

namespace Sven\ForgeCLI\Commands;

use Sven\ForgeCLI\Config;
use Themsaid\Forge\Forge;
use Symfony\Component\Console\Helper\Table;
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
     * @var array
     */
    protected $optionMap = [];

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
        if (! $this->needsForge) {
            $this->perform($input, $output);

            return;
        }

        $key = (new Config)->get('key');

        $this->forge = new Forge($key);

        $this->perform($input, $output);
    }

    /**
     * @param OutputInterface $output
     * @param array $header
     * @param array $rows
     */
    protected function table(OutputInterface $output, array $header, array $rows)
    {
        $table = new Table($output);
        $table->setHeaders($header)
            ->setRows($rows);

        $table->render();
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function fillData(array $options)
    {
        $data = [];

        foreach ($this->optionMap as $option => $requestKey) {
            if (! isset($options[$option])) {
                continue;
            }

            $data[$requestKey] = $options[$option];
        }

        return $data;
    }
}
