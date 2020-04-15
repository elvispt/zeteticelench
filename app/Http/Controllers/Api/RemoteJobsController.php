<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Repos\RemoteJobs\RemoteJobs;
use Illuminate\Http\JsonResponse;

class RemoteJobsController extends Controller
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

    public function index(): JsonResponse
    {
        $remoteJobs = new RemoteJobs();

        return ApiResponse::response($remoteJobs->jobs());
    }
}
