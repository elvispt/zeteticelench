<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Libraries\SysInfo\SysInfo;
use Illuminate\Http\JsonResponse;

class SystemInfoController extends Controller
{
    public function index(): JsonResponse
    {
        $sysInfo = new SysInfo();

        return ApiResponse::response($sysInfo->all());
    }
}
