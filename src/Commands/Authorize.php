<?php

namespace Sven\ForgeCLI\Commands;

use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class Authorize extends BaseCommand implements NeedsForge
{
    public function configure(): void
    {
        $this->setName('authorize')
            ->setDescription('Set or update the API key used in the commands.')
            ->addArgument('key', InputArgument::OPTIONAL, 'Forge API Key');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$input->getArgument('key')) {
            /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
            $helper = $this->getHelper('question');

            $question = new Question('What is your API key? ');
            $question->setHidden(true);

            $this->config->set('key', $helper->ask($input, $output, $question));
        } else {
            $this->config->set('key', $input->getArgument('key'));
        }

        $this->config->persist();

        $output->write('<info>Your API key has successfully been set.</info>');

        return 0;
    }
}
