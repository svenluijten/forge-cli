<?php

namespace Sven\ForgeCLI\Commands;

trait ConfirmableTrait
{
    /**
     * Confirm before proceeding with the action.
     *
     * This method only asks for confirmation in production.
     *
     * @param  string  $warning
     * @param  \Closure|bool|null  $callback
     * @return bool
     */
    public function confirmToProceed($warning = 'Destructive Command running!')
    {
        if ($this->hasOption('force') && $this->option('force')) {
            return true;
        }

        $this->alert($warning);

        $confirmed = $this->confirm('Do you really wish to run this command?');

        if (! $confirmed) {
            $this->comment('Command Cancelled!');

            return false;
        }

        return true;
    }

}
