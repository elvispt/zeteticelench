<?php

namespace App\Http\Controllers;

class SpaController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view("app");
    }
}
