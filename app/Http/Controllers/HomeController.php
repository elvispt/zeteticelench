<?php

namespace App\Http\Controllers;

use App\Repos\Calendarific;
use App\Repos\Unsplash\Unsplash;
use App\Repos\Unsplash\UnsplashApi;

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
        $unsplash = new Unsplash();

        return view('home', [
            'unsplash' => $unsplash->getUnsplashFeaturedImage(new UnsplashApi()),
            'nextHolidays' => $nextHolidays,
        ]);
    }
}
