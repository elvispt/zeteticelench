<?php

namespace App\Repos\Calendarific;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException
    as SimpleCacheInvalidArgumentException;

class Calendarific
{
    /**
     * Store on cache for how long?
     *
     * @var int
     */
    protected $cacheExpiration;

    /**
     * Calendarific constructor.
     *
     * @param int $cacheExpiration Defaults to 1 day expiration
     */
    public function __construct(int $cacheExpiration = 86400)
    {
        $this->cacheExpiration = $cacheExpiration;
    }

    /**
     * Gets the holidays for the given country and year
     *
     * @param CalendarificApi $calendarificApi
     * @param string|null     $year     Optional. The year of the holidays.
     * @param string          $country  Optional. The country code.
     * @param string          $location Optional. The region name.
     * @return array Returns the holidays
     */
    public function holidays(
        CalendarificApi $calendarificApi,
        ?string $year = null,
        string $country = 'pt',
        string $location = 'Madeira'
    ) {
        $year = $year ? $year : date('Y');
        $cacheKey = $this->cacheKey($year, $country, $location);

        $holidays = Cache::get($cacheKey);
        if (is_null($holidays)) {
            $holidays = $calendarificApi->getHolidays(
                $year,
                $country,
                $location
            );
            $holidays = data_get($holidays, 'response.holidays');
            try {
                Cache::set($cacheKey, $holidays, $this->cacheExpiration);
            } catch (SimpleCacheInvalidArgumentException $exception) {
                Log::error(
                    "Failed to store holidays on cache",
                    ['eMessage' => $exception->getMessage()]
                );
            }
        }

        return $holidays;
    }

    /**
     * Gets the next number of holidays based on current date/time.
     *
     * @param array $holidays             The holidays list
     * @param int   $numberOfNextHolidays The number of next holidays to obtain
     * @return array Returns the next holidays
     */
    public function getNextHolidays($holidays = [], $numberOfNextHolidays = 3)
    {
        $currentDateTime = Carbon::now();

        return (new Collection($holidays))
            ->filter(static function ($holiday) use ($currentDateTime) {
                $holidayDateTime = Carbon::make($holiday->date->iso);

                return $currentDateTime->lte($holidayDateTime);
            })
            ->slice(0, $numberOfNextHolidays)
            ->toArray();
    }

    /**
     * Generates a cache key based on provided params
     *
     * @param string $year     Year of the holidays
     * @param string $country  Country of the holidays
     * @param string $location The location of the holidays
     * @return string Returns the generated cache key.
     */
    protected function cacheKey(
        string $year,
        string $country,
        string $location
    ): string {
        return static::class . $year . $country . $location;
    }
}
