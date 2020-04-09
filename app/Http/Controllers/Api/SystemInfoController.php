<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Libraries\SysInfo\SysInfo;
use Illuminate\Http\JsonResponse;

class SystemInfoController extends Controller
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
        $sysInfo = new SysInfo();

        return ApiResponse::response($sysInfo->all());
    }
}
