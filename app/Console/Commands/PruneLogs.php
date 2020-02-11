<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Prune logs older than 10 days
 *
 * @package App\Console\Commands
 */
class PruneLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prune:logs
        {--d|days=10 : How many days old should the files be}
        {--f|force : Run without confirmation}'
    ;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prunes logs older than 10 days';

    /**
     * Execute the console command. If the caller provides invalid data,
     * error messages will be shown in the command line.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $pruneLogs = new \App\Libraries\PruneLogs\PruneLogs();
        $files = $pruneLogs->filesToBeDeleted($days);
        if ($files->isEmpty()) {
            $this->info("No files found older than ${days} days.");
            return;
        }
        $this->info('');
        $this->warn("Files older than ${days} day(s) to be deleted:");
        $this->outputFileList($files);
        if ($this->shouldRun()) {
            $pruneLogs->deleteFiles($files);
            $this->warn('Files where deleted.');
            $this->info('');
        }
    }

    /**
     * Outputs the file list as a table to the cli.
     *
     * @param Collection $files The files metadata.
     */
    protected function outputFileList(Collection $files): void
    {
        $rows = $files->map(static function (array $file) {
            return [
                $file['path'],
                Carbon::createFromTimestamp($file['timestamp'])
                    ->format('Y-m-d H:i:s'),
                    str_pad(round($file['size'] / 1024, 2) . 'KB', 10, ' ', STR_PAD_LEFT),
            ];
        });
        $this->table([
            'Path', 'Last change', 'Size'
        ], $rows->values()->toArray());
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
