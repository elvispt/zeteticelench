<?php

namespace App\Http\Controllers;

use App\Repos\Calendarific;
use App\Repos\Unsplash;

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
        $cal = new Calendarific();
        $holidays = $cal->holidays();
        $nextHolidays = $cal->getNextHolidays($holidays);
        return view('home', [
            'unsplash' => (new Unsplash())->getUnsplashFeaturedImage(),
            'nextHolidays' => $nextHolidays,
        ]);
    }
}
