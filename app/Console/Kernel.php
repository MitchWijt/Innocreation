<?php

namespace App\Console;

use App\Payments;
use App\SiteSetting;
use App\Team;
use App\TeamPackage;
use App\CustomTeamPackage;
use App\User;
use App\SplitTheBillLinktable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Services\AppServices\MailgunService;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\ReccuringPayment',
        'App\Console\Commands\WelcomeMails',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        date_default_timezone_set("Europe/Amsterdam");
        $schedule->command('recurring:payment')->everyTenMinutes();
//        $schedule->command('welcome:mail')->everyMinute();
    }
}
