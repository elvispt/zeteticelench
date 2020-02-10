<?php

namespace App\Console;

use App\Console\Commands\PruneLogs;
use App\Console\Commands\StaleTags;
use App\Libraries\Reddit\GameDeals;
use App\Repos\HackerNews\HackerNews;
use App\Repos\HackerNews\HackerNewsImport;
use App\Repos\HackerNews\HnApi;
use App\Repos\Unsplash\Unsplash;
use App\Repos\Unsplash\UnsplashApi;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $logDate = date('Ymd');

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
            $hackerNewsImport = new HackerNewsImport();
            $hackerNewsImport->importUpdatedStories(new HnApi());
            $hackerNewsImport->importNew(new HnApi());
            $hackerNewsImport->importTop(new HnApi());
            $hackerNewsImport->importBest(new HnApi());
            $hackerNewsImport->importJobs(new HnApi());
        })->everyMinute();

        $schedule->call(static function () {
            $unsplash = new Unsplash();
            $unsplash->getUnsplashFeaturedImage(new UnsplashApi(), true);
        })->everyFiveMinutes();

        $schedule->command('telescope:prune')->everyFifteenMinutes();

        $schedule
            ->command(StaleTags::class, ['--force'])
            ->everyThirtyMinutes()
            ->appendOutputTo(storage_path("logs/scheduler-${logDate}.log"));

        $schedule
            ->command(PruneLogs::class, ['--force'])
            ->daily()
            ->appendOutputTo(storage_path("logs/scheduler-${logDate}.log"));

        $schedule
            ->call(static function () {
                $gameDeals = new GameDeals();
                $gameDeals->get();
            })
            ->weekly()->fridays()->at('18:00')
            ->environments(['production'])
        ;
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
