<?php

namespace Sven\ForgeCLI\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class MakeAlias extends BaseCommand
{
    public function configure()
    {
        $this->setName('make:alias')
            ->addArgument('alias', InputArgument::REQUIRED, 'The alias to give your server and/or site.')
            ->addArgument('server', InputArgument::OPTIONAL, 'The id of the server you want to alias.')
            ->addArgument('site', InputArgument::OPTIONAL, 'The id of the site you want to alias. May be left empty.')
            ->setDescription('Add an alias for a server and/or site.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $alias = $input->getArgument('alias');

        if (preg_match('/[^a-z0-9\-\_]/i', $alias)) {
            throw new \InvalidArgumentException('An alias can only contain alphanumeric characters, dashes (-), and underscores (_).');
        }

        $this->config->set('aliases.'.$alias, [
            'server' => $server = $this->server($input, $output),
            'site' => $site = $this->site($input, $output),
        ]);

        $output->writeln("<info>{$this->getMessage($alias, $server, $site)}</info>");

        $this->config->persist();

        return 1;
    }

    protected function server(InputInterface $input, OutputInterface $output)
    {
        if ($server = $input->getArgument('server')) {
            return $server;
        }

        return $this->ask('What server would you like to alias?', $input, $output);
    }

    protected function site(InputInterface $input, OutputInterface $output)
    {
        if ($site = $input->getArgument('site')) {
            return $site;
        }

        if ($output->isQuiet()) {
            return null;
        }

        return $this->ask('What site would you like to alias? (Leave blank to skip)', $input, $output);
    }

    protected function ask(string $question, InputInterface $input, OutputInterface $output): ?string
    {
        /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
        $helper = $this->getHelper('question');

        return $helper->ask($input, $output, new Question($question));
    }

    protected function getMessage(string $alias, string $server, ?string $site): string
    {
        $message = 'Successfully created alias "'.$alias.'" for server "'.$server.'"';

        if ($site !== null) {
            $message .= " and site '$site'";
        }

        return $message.'.';
    }
}
