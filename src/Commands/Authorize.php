<?php

namespace Sven\ForgeCLI\Commands;

use Sven\ForgeCLI\Config;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Authorize extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected $needsForge = false;

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
    public function perform(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('What is your API key? ');
        $question->setHidden(true);

        (new Config)->set('key', $helper->ask($input, $output, $question));

        $output->write('<info>Your API key has successfully been set.</info>');
    }
}
