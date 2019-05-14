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
    protected $signature = 'tags:stale {--f|force : Run without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all stale tags';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $staleTags = 0;
        if ($this->shouldRun()) {
            $tag = new Tag();
            $staleTags = $tag->clearStale();
        }
        $this->info("Removed $staleTags stale tags.");
    }

    protected function shouldRun()
    {
        return $this->option('force') || $this->confirm("This is a destructive command. Continue?");
    }
}
