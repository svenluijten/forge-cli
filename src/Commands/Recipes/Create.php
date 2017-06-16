<?php

namespace Sven\ForgeCLI\Commands\Recipes;

use Sven\ForgeCLI\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends BaseCommand
{
    /**
     * @var array
     */
    protected $optionMap = [
        'name' => 'name',
        'user' => 'user',
    ];

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('make:recipe')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'The name of the recipe.')
            ->addOption('user', null, InputOption::VALUE_REQUIRED, 'The user the recipe should run as.', 'root')
            ->addOption('script', null, InputOption::VALUE_REQUIRED, 'The contents of the recipe.')
            ->setDescription('Create a new recipe.');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $payload = $this->fillData($input->getOptions());

        $payload['script'] = $this->getFileContent($input, 'script');

        $this->forge->createRecipe($payload);
    }
}
