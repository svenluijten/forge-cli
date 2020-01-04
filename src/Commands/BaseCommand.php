<?php

namespace Sven\ForgeCLI\Commands;

use InvalidArgumentException;
use RuntimeException;
use Sven\FileConfig\Drivers\Json;
use Sven\FileConfig\File;
use Sven\FileConfig\Store;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Laravel\Forge\Forge;

abstract class BaseCommand extends Command
{
    protected Forge $forge;
    protected array $optionMap = [];

    public function __construct(protected Store $config, ?Forge $forge = null)
    {
        parent::__construct();

        if ($this instanceof NeedsForge) {
            $this->forge = $forge ?: new Forge($this->config->get('key'));
        }
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        if (!$input->hasArgument('server')) {
            return;
        }

        // If the 'site' argument is present, the user probably did not
        // use an alias, so we will return early. If it is missing,
        // resolve the alias and set the arguments accordingly.
        if ($input->hasArgument('site') && $input->getArgument('site') !== null) {
            return;
        }

        $alias = $this->config->get(
            'aliases.'.$input->getArgument('server')
        );

        // No alias was found by that name, so we will
        // continue executing the command here. This
        // will cause a validation error later on.
        if ($alias === null) {
            $output->writeln('<error>No alias found for "'.$input->getArgument('server').'".</error>');

            return;
        }

        // Could not find alias for site, continue executing the
        // command to cause an error later on by Symfony's own
        // validation that takes place after this method.
        if (!isset($alias['site']) && $input->hasArgument('site')) {
            $output->writeln('<error>No site alias found, but a site is required for this command.</error>');

            return;
        }

        if (!$output->isQuiet()) {
            $message = 'Using aliased server "'.$alias['server'].'"';

            if ($input->hasArgument('site')) {
                $message .= ' and site "'.$alias['site'].'"';
            }

            $output->writeln('<comment>'.$message.'.</comment>');
        }

        $input->setArgument('server', $alias['server']);

        if ($input->hasArgument('site')) {
            $input->setArgument('site', $alias['site']);
        }
    }

    protected function table(OutputInterface $output, array $header, array $rows)
    {
        $table = new Table($output);
        $table->setHeaders($header)
            ->setRows($rows);

        $table->render();
    }

    protected function fillData(array $options, array $optionMap = null): array
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

    protected function getFileContent(InputInterface $input, string $option): bool|string
    {
        $filename = $input->hasOption($option) ? $input->getOption($option) : 'php://stdin';

        if (!file_exists($filename)) {
            return $filename;
        }

        if ($filename && ftell(STDIN) !== false) {
            return file_get_contents($filename);
        }

        throw new InvalidArgumentException('This command requires either the "--'.$option.'" option to be set, or an input from STDIN.');
    }

    protected function requireOptions(InputInterface $input, string ...$keys): void
    {
        foreach ($keys as $key) {
            if ($input->hasOption($key)) {
                continue;
            }

            throw new RuntimeException(
                sprintf('The option "%s" is required.', $key)
            );
        }
    }

    protected function getFileConfig(): Store
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
