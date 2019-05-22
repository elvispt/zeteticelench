<?php

namespace App\Console;

use App\Console\Commands\StaleTags;
use App\Repos\HackerNews;
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
            ->sendOutputTo(storage_path("logs/scheduler-$logDate.log"));
        $schedule->command('telescope:prune')->everyFifteenMinutes();
        $schedule->call(static function () {
            $hackerNews = new HackerNews();
            $hackerNews->getTopStories(true);
        })->everyFiveMinutes();
        $schedule->call(static function () {
            $hackerNews = new HackerNews();
            $hackerNews->getBestStories(true);
        })->everyFiveMinutes();
        $schedule->call(static function () {
            $hackerNews = new HackerNews();
            $hackerNews->getJobStories(true);
        })->everyFiveMinutes();
        $schedule->call(static function () {
           $un = new Unsplash();
           $un->getUnsplashFeaturedImage(true);
        })->everyFiveMinutes();
        $schedule->call(static function () {
            $hn = new \App\Repos\HackerNews\HackerNews();
            $hn->importAll();
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
