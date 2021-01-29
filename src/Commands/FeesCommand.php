<?php

namespace Tipoff\Fees\Commands;

use Illuminate\Console\Command;

class FeesCommand extends Command
{
    public $signature = 'fees';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
