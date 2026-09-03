<?php

namespace Hwkdo\IntranetAppZentrale\Commands;

use Illuminate\Console\Command;

class IntranetAppZentraleCommand extends Command
{
    public $signature = 'intranet-app-zentrale';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
