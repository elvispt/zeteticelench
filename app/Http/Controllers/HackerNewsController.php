<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HackerNewsController extends Controller
{
    /**
     * Loads the HackerNews application
     *
     * @param Request                     $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return View::make('vuejs/hn');
    }
}
