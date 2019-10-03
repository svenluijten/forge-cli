<?php

namespace Sven\ForgeCLI\Commands\Sites;

use Sven\ForgeCLI\Commands\BaseCommand;
use Sven\ForgeCLI\Commands\ConfirmableTrait;
use Sven\ForgeCLI\Contracts\NeedsForge;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Delete extends BaseCommand implements NeedsForge
{
    use ConfirmableTrait;

    protected $name = 'delete:site';

    protected $description = 'Delete a site.';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['server', InputArgument::REQUIRED, 'The id of the server where the site is.'],
            ['site', InputArgument::REQUIRED, 'The id of the site to delete.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'If we want to execute without interaction'],
        ];
    }

    public function handle()
    {
        $site = $this->argument('site');

        if (! $this->confirmToProceed("You are going to delete the site with id {$site}.")) {
            return;
        }

        $this->forge->deleteSite($this->argument('server'), $site);
    }
}
