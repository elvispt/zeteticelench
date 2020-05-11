<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class NotesController extends Controller
{
    /**
     * Shows the list of notes
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return View::make('vuejs/notes');
    }
}
