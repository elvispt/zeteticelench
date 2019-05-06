<?php

namespace App\Console\Commands;

use App\Models\Tag;
use Illuminate\Console\Command;

class StaleTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all stale tags';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $staleTags = 0;
        if ($this->confirm("This is a destructive command. Continue?")) {
            $tag = new Tag();
            $staleTags = $tag->clearStale();
        }
        $this->info("Removed $staleTags stale tags.");
    }
}
