<?php

namespace App\Console;

use App\Console\Commands\PruneLogs;
use App\Console\Commands\StaleTags;
use App\Libraries\Inspire\Inspire;
use App\Libraries\Reddit\GameDeals;
use App\Libraries\Reddit\GameDealsFree;
use App\Repos\Calendarific\Calendarific;
use App\Repos\Calendarific\CalendarificApi;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\DbSnapshots\Commands\Create;

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
        $schedulerLogPath = storage_path("logs/scheduler-${logDate}.log");

        $schedule->call(static function () {
            (new Inspire())->adviceSlip();
        })->everyFiveMinutes();

        $schedule->command('telescope:prune')->everyFifteenMinutes();

        $schedule
            ->command(StaleTags::class, ['--force'])
            ->everyThirtyMinutes()
            ->appendOutputTo($schedulerLogPath);

        $schedule->call(static function () {
            $calendarific = new Calendarific();
            $calendarificApi = new CalendarificApi();
            $calendarific->holidays($calendarificApi);
        })->twiceDaily(3, 15);

        $schedule
            ->command(PruneLogs::class, ['--force'])
            ->daily()
            ->appendOutputTo($schedulerLogPath);

        $schedule
            ->call(static function () {
                $gameDeals = new GameDeals(new GameDealsFree());
                $gameDeals->run();
            })
            ->daily()->at('20:00')
            ->environments(['production'])
        ;

        $this->snapshots($schedule, $schedulerLogPath);
    }

    /**
     * Backups DB to Dropbox
     *
     * @param Schedule $schedule
     * @param string   $schedulerLogPath
     */
    protected function snapshots(Schedule $schedule, string $schedulerLogPath)
    {
        $schedule
            ->command('snapshot:create --compress')
            ->dailyAt('03:01')
            ->appendOutputTo($schedulerLogPath)
        ;
        $schedule
            ->command('snapshot:cleanup --keep=5')
            ->dailyAt('03:03')
            ->appendOutputTo($schedulerLogPath)
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
