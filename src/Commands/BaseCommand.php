<?php

namespace Sven\ForgeCLI\Commands;

use Sven\FileConfig\Drivers\Json;
use Sven\FileConfig\File;
use Sven\FileConfig\Store;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Themsaid\Forge\Forge;

abstract class BaseCommand extends Command
{
    /**
     * @var \Themsaid\Forge\Forge
     */
    protected $forge;

    /**
     * @var \Sven\FileConfig\Store
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

        if ($this instanceof NeedsForge) {
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
            if (!isset($options[$option])) {
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

        if (!file_exists($filename)) {
            throw new \InvalidArgumentException('The file provided "'.$filename.'" was not found.');
        }

        if ($filename && ftell(STDIN) !== false) {
            return file_get_contents($filename);
        }

        throw new \InvalidArgumentException('This command requires either the "--'.$option.'" option to be set, or an input from STDIN.');
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
     * @return \Sven\FileConfig\Store
     */
    protected function getFileConfig()
    {
        $homeDirectory = (
            strncasecmp(PHP_OS, 'WIN', 3) === 0
                ? $_SERVER['USERPROFILE']
                : $_SERVER['HOME']
            ).DIRECTORY_SEPARATOR;

        $visibleConfigFile = $homeDirectory.'forge.json';
        $hiddenConfigFile = $homeDirectory.'.forge.json';

        // If an existing visible configuration file exists, continue using it.
        if (file_exists($visibleConfigFile)) {
            return new Store(new File($visibleConfigFile), new Json());
        }

        // If a hidden configuration file does not exist, create it.
        if (!file_exists($hiddenConfigFile)) {
            file_put_contents($hiddenConfigFile, '{"key":""}');
        }

        // Return the hidden configuration file.
        return new Store(new File($hiddenConfigFile), new Json());
    }
}
