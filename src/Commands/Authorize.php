<?php

namespace Sven\ForgeCLI\Commands;

use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class Authorize extends BaseCommand implements NeedsForge
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('authorize')
            ->setDescription('Set or update the API key used in the commands.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('What is your API key? ');
        $question->setHidden(true);

        $this->config->set('key', $helper->ask($input, $output, $question));
        $this->config->persist();

        $output->write('<info>Your API key has successfully been set.</info>');
    }
}
