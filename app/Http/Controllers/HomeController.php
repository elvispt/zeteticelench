<?php

namespace App\Http\Controllers;

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
        $remoteJobs = new RemoteJobs();
        return view("vuejs/home/home", [
            'jobs' => $remoteJobs->jobs(),
        ]);
    }
}
