<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Libraries\Inspire\Inspire;

class InspireController extends Controller
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

    public function index()
    {
        $inspire = new Inspire();

        return ApiResponse::response($inspire->adviceSlip());
    }
}
