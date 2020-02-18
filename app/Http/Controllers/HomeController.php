<?php

namespace App\Http\Controllers;

use App\Libraries\SysInfo\SysInfo;
use App\Repos\Calendarific\Calendarific;
use App\Repos\Calendarific\CalendarificApi;
use App\Repos\RemoteJobs\RemoteJobs;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sysInfo = new SysInfo();
        $calendarific = new Calendarific();
        $calendarificApi = new CalendarificApi();
        $holidays = $calendarific->holidays($calendarificApi);
        $nextHolidays = $calendarific->getNextHolidays($holidays);

        $remoteJobs = new RemoteJobs();
        return view('home', [
            'nextHolidays' => $nextHolidays,
            'sysInfo' => $sysInfo->all(),
            'jobs' => $remoteJobs->jobs(),
        ]);
    }
}
