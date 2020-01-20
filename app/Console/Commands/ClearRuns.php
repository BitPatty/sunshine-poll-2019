<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Run;
use Illuminate\Console\Command;

class ClearRuns extends Command
{
    protected $signature = 'runs:clear';

    protected $description = 'Removes all runs from the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Run::truncate();
        \DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        Category::truncate();
        \DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }
}
