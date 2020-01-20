<?php

namespace Tests\Feature;

use App\Repos\Calendarific\Calendarific;
use App\Repos\Calendarific\CalendarificApi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CalendarificTest extends TestCase
{
    public function testGetHolidays()
    {
        $calendarific = new Calendarific();
        $calendarificApi = new CalendarificApi();
        $holidays = $calendarific->holidays($calendarificApi);
        $this->assertIsArray($holidays);
        $this->assertTrue(count($holidays) > 0);
    }

    public function testGetHolidaysFromCache()
    {
        $data = [
            (object) [
                'name' => "Holiday 1",
                'description' => "Holiday description 1",
                'date' => (object) [
                    'iso' => "2019-01-01",
                    'datetime' => (object) [
                        'year' => 2019,
                        'month' => 1,
                        'day' => 1,
                    ],
                ],
                'type' => ["National Holiday"],
                'locations' => "All",
                'states' => "All",
            ],
            (object) [
                'name' => "Holiday 2",
                'description' => "Holiday description 2",
                'date' => (object) [
                    'iso' => "2019-03-06",
                    'datetime' => (object) [
                        'year' => 2019,
                        'month' => 3,
                        'day' => 6,
                    ],
                ],
                'type' => ["National Holiday"],
                'locations' => "All",
                'states' => "All",
            ],
        ];
        $year = date('Y');
        $country = 'pt';
        $location = 'Madeira';
        $cacheKey = Calendarific::class . $year . $country . $location;
        Cache::shouldReceive('get')
            ->once()
            ->with($cacheKey)
            ->andReturn($data);
        $calendarific = new Calendarific();
        $calendarificApi = new CalendarificApi();
        $holidays = $calendarific->holidays($calendarificApi);
        $this->assertIsArray($holidays);
        $this->assertTrue(count($holidays) > 0);
    }

    public function testGetHolidaysCallsApiWhenCacheIsEmpty()
    {
        $data = [
            (object) [
                'name' => "Holiday 1",
                'description' => "Holiday description 1",
                'date' => (object) [
                    'iso' => "2019-01-01",
                    'datetime' => (object) [
                        'year' => 2019,
                        'month' => 1,
                        'day' => 1,
                    ],
                ],
                'type' => ["National Holiday"],
                'locations' => "All",
                'states' => "All",
            ],
            (object) [
                'name' => "Holiday 2",
                'description' => "Holiday description 2",
                'date' => (object) [
                    'iso' => "2019-03-06",
                    'datetime' => (object) [
                        'year' => 2019,
                        'month' => 3,
                        'day' => 6,
                    ],
                ],
                'type' => ["National Holiday"],
                'locations' => "All",
                'states' => "All",
            ],
        ];
        $dataFromApi = (object) [
            'response' => (object) [
                'holidays' => $data
            ],
        ];
        $year = date('Y');
        $country = 'pt';
        $location = 'Madeira';
        $cacheExpiration = 666;
        $cacheKey = Calendarific::class . $year . $country . $location;
        Cache::shouldReceive('get')
             ->once()
             ->with($cacheKey)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->once()
             ->with($cacheKey, $data, $cacheExpiration)
             ->andReturnTrue();

        $mock = $this->getMockBuilder(CalendarificApi::class)
                     ->getMock();
        $mock
            ->expects($this->once())
            ->method('getHolidays')
            ->will($this->returnValue($dataFromApi));

        $calendarific = new Calendarific($cacheExpiration);
        $holidays = $calendarific->holidays(
            $mock,
            $year,
            $country,
            $location
        );
        $this->assertIsArray($holidays);
        $this->assertTrue(count($holidays) > 0);
    }

    public function testGetNextHolidays()
    {
        $carbonBefore = Carbon::now();
        $carbonNext = Carbon::now();
        $data = [
            (object) [
                'name' => "Holiday 1",
                'description' => "Holiday description 1",
                'date' => (object) [
                    'iso' => $carbonBefore->addDays(-5)->format('Y-m-d'),
                    'datetime' => (object) [
                        'year' => $carbonBefore->year,
                        'month' => $carbonBefore->month,
                        'day' => $carbonBefore->day,
                    ],
                ],
                'type' => ["National Holiday"],
                'locations' => "All",
                'states' => "All",
            ],
            (object) [
                'name' => "Holiday 2",
                'description' => "Holiday description 2",
                'date' => (object) [
                    'iso' => $carbonBefore->addDays(-10)->format('Y-m-d'),
                    'datetime' => (object) [
                        'year' => $carbonBefore->year,
                        'month' => $carbonBefore->month,
                        'day' => $carbonBefore->day,
                    ],
                ],
                'type' => ["National Holiday"],
                'locations' => "All",
                'states' => "All",
            ],
            (object) [
                'name' => "Holiday 3",
                'description' => "Holiday description 3",
                'date' => (object) [
                    'iso' => $carbonNext->addDays(5)->format('Y-m-d'),
                    'datetime' => (object) [
                        'year' => $carbonBefore->year,
                        'month' => $carbonBefore->month,
                        'day' => $carbonBefore->day,
                    ],
                ],
                'type' => ["National Holiday"],
                'locations' => "All",
                'states' => "All",
            ],
            (object) [
                'name' => "Holiday 4",
                'description' => "Holiday description 4",
                'date' => (object) [
                    'iso' => $carbonNext->addDays(10)->format('Y-m-d'),
                    'datetime' => (object) [
                        'year' => $carbonBefore->year,
                        'month' => $carbonBefore->month,
                        'day' => $carbonBefore->day,
                    ],
                ],
                'type' => ["National Holiday"],
                'locations' => "All",
                'states' => "All",
            ],
        ];
        $year = date('Y');
        $country = 'pt';
        $location = 'Madeira';
        $cacheKey = Calendarific::class . $year . $country . $location;
        Cache::shouldReceive('get')
             ->once()
             ->with($cacheKey)
             ->andReturn($data);
        $calendarific = new Calendarific();
        $calendarificApi = new CalendarificApi();
        $holidays = $calendarific->holidays($calendarificApi);
        $this->assertIsArray($holidays);
        $this->assertTrue(count($holidays) > 0);
        $nextHolidays = $calendarific->getNextHolidays($holidays);
        $this->assertIsArray($nextHolidays);
        $this->assertCount(2, $nextHolidays);
    }
}
