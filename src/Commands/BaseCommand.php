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
     * @var \Themsaid\Forge\Forge
     */
    protected $forge;

    /**
     * @var array
     */
    protected $optionMap = [];

    /**
     * @param \Themsaid\Forge\Forge|null $forge
     */
    public function __construct(Forge $forge = null)
    {
        parent::__construct();

        if ($this->needsForge) {
            $this->forge = $forge ?: new Forge((new Config)->get('key'));
        }
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param array                                             $header
     * @param array                                             $rows
     */
    protected function table(OutputInterface $output, array $header, array $rows)
    {
        $table = new Table($output);
        $table->setHeaders($header)
            ->setRows($rows);

        $table->render();
    }

    /**
     * @param array      $options
     * @param array|null $optionMap
     *
     * @return array
     */
    protected function fillData(array $options, array $optionMap = null)
    {
        $data = [];

        foreach ($optionMap ?: $this->optionMap as $option => $requestKey) {
            if (! isset($options[$option])) {
                continue;
            }

            $data[$requestKey] = $options[$option];
        }

        return $data;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param string                                          $option
     *
     * @return bool|string
     */
    protected function getFileContent(InputInterface $input, $option)
    {
        $filename = $input->hasOption($option) ? $input->getOption($option) : 'php://stdin';

        if (! file_exists($filename)) {
            return $filename;
        }

        if ($filename && ftell(STDIN) !== false) {
            return file_get_contents($filename);
        }

        throw new \InvalidArgumentException('This command requires either the "--'.$option.'" option to be set or an input from STDIN.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param array                                           ...$keys
     *
     * @throws \RuntimeException
     */
    protected function requireOptions(InputInterface $input, ...$keys)
    {
        foreach ($keys as $key) {
            if ($input->hasOption($key)) {
                continue;
            }

            throw new \RuntimeException(
                sprintf('The option "%s" is required.', $key)
            );
        }
    }
}
