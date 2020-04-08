<?php

namespace App\Http\Controllers;

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
        $calendarific = new Calendarific();
        $calendarificApi = new CalendarificApi();
        $holidays = $calendarific->holidays($calendarificApi);
        $nextHolidays = $calendarific->getNextHolidays($holidays);

        $remoteJobs = new RemoteJobs();
        return view("vuejs/home/home", [
            'nextHolidays' => $nextHolidays,
            'jobs' => $remoteJobs->jobs(),
        ]);
    }
}
