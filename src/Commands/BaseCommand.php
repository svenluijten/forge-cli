<?php

namespace Sven\ForgeCLI\Commands;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Sven\FileConfig\File;
use Sven\FileConfig\Stores\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Themsaid\Forge\Forge;

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
     * @var \Sven\FileConfig\Stores\Json
     */
    protected $config;

    /**
     * @var array
     */
    protected $optionMap = [];

    /**
     * @param \Themsaid\Forge\Forge|null $forge
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     * @throws \LogicException
     */
    public function __construct(Forge $forge = null)
    {
        parent::__construct();

        $this->config = $this->getFileConfig();

        if ($this->needsForge) {
            $this->forge = $forge ?: new Forge($this->config->get('key'));
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

    /**
     * @throws \LogicException
     *
     * @return \Sven\FileConfig\Stores\Json
     */
    protected function getFileConfig()
    {
        $home = strncasecmp(PHP_OS, 'WIN', 3) === 0 ? $_SERVER['USERPROFILE'] : $_SERVER['HOME'];

        $adapter = new Local($home);
        $filesystem = new Filesystem($adapter);

        if (! $filesystem->has('forge.json')) {
            $filesystem->write('forge.json', '');
        }

        return new Json(
            new File($home.DIRECTORY_SEPARATOR.'forge.json')
        );
    }
}
