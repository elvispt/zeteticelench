<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Repos\Calendarific\Calendarific;
use App\Repos\Calendarific\CalendarificApi;
use Illuminate\Http\JsonResponse;

class NextHolidaysController extends Controller
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
        $calendarific = new Calendarific();
        $calendarificApi = new CalendarificApi();
        $holidays = $calendarific->holidays($calendarificApi);
        $nextHolidays = $calendarific->getNextHolidays($holidays);

        return ApiResponse::response($nextHolidays);
    }
}
