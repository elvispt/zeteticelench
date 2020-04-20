<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Repos\RemoteJobs\RemoteJobs;
use Illuminate\Http\JsonResponse;

class RemoteJobsController extends Controller
{
    public function index(): JsonResponse
    {
        $remoteJobs = new RemoteJobs();

        return ApiResponse::response($remoteJobs->jobs());
    }
}
