<?php

namespace App\Console;

use App\Console\Commands\StaleTags;
use App\Repos\HackerNews\HackerNews;
use App\Repos\HackerNews\HackerNewsImport;
use App\Repos\Unsplash;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $logDate = date('Ymd');
        $schedule
            ->command(StaleTags::class, ['--force'])
            ->everyMinute()
            ->appendOutputTo(storage_path("logs/scheduler-$logDate.log"));

        $schedule->command('telescope:prune')->everyFifteenMinutes();

        $schedule->call(static function () {
            $hackerNews = new HackerNews();
            $hackerNews->getTopStories(config('hackernews.list_limit'), 0, true);
        })->everyMinute();

        $schedule->call(static function () {
            $hackerNews = new HackerNews();
            $hackerNews->getBestStories(config('hackernews.list_limit'), 0, true);
        })->everyMinute();

        $schedule->call(static function () {
            $hackerNews = new HackerNews();
            $hackerNews->getJobStories(config('hackernews.list_limit'), 0, true);
        })->everyMinute();

        $schedule->call(static function () {
           $unsplash = new Unsplash();
           $unsplash->getUnsplashFeaturedImage(true);
        })->everyFiveMinutes();

        $schedule->call(static function () {
            $hackerNewsImport = new HackerNewsImport();
            $hackerNewsImport->importAll();
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
