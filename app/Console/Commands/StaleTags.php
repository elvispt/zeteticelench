<?php

namespace App\Console\Commands;

use App\Models\Tag;
use Illuminate\Console\Command;

/**
 * Clears also unused tags from the system.
 * Allows to be called without confirmation, useful when used as a scheduled
 * command.
 *
 * @package App\Console\Commands
 */
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
     */
    public function handle()
    {
        if ($this->shouldRun()) {
            $tag = new Tag();
            $staleTags = $tag->clearStale();
            $this->info("Removed ${staleTags} stale tags.");
        } else {
            $this->info('Canceled!');
        }
    }

    /**
     * Ask the user for confirmation since this is a destructive command.
     *
     * @return bool
     */
    protected function shouldRun()
    {
        $question = 'This is a destructive command. Continue?';
        return $this->option('force') || $this->confirm($question);
    }
}
