<?php

namespace App\Libraries\SysInfo;

use DateTimeZone;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SysInfo
{
    /**
     * Uptime as an english text string.
     *
     * @return string
     */
    public function up(): string
    {
        $up = '';
        try {
            $up = exec('uptime -p');
        } catch (Exception $exception) {
            Log::error(
                "Could not get uptime with command: uptime -p",
                ['eMessage' => $exception->getMessage()]
            );
        }

        return $up;
    }

    /**
     * Returns the date/time of when the system was booted.
     *
     * @return string
     */
    public function upSince(): string
    {
        $sinceText = '';

        try {
            $systemUpSince = exec('uptime -s');
        } catch (Exception $exception) {
            Log::error(
                "Could not get uptime with command: uptime -p",
                ['eMessage' => $exception->getMessage()]
            );
            $systemUpSince = null;
        }

        if (! is_null($systemUpSince)) {
            try {
                $since = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $systemUpSince,
                    new DateTimeZone('UTC')
                );
                $since->setTimezone(new DateTimeZone('Europe/Lisbon'));
            } catch (Exception $exception) {
                Log::error(
                    "Failed to create dt object on system uptime",
                    ['eMessage' => $exception->getMessage()]
                );
                $since = null;
            }
            if (! is_null($since)) {
                $sinceText = $since->format('Y-m-d H:i:s');
            }
        }

        return $sinceText;
    }

    /**
     * Shows system memory info
     *
     * @return array
     */
    public function memory()
    {
        $output = [];
        exec('free -h', $output);
        $memLine = $output[1];
        $matches = [];
        preg_match_all("~[1-9]\d*(\.\d+)?[M|G]~", $memLine, $matches);
        [$total, $used, $free, $shared, $buffCache, $available] = $matches[0];

        return [
            'total' => $total,
            'used' => $used,
            'free' => $free,
            'shared' => $shared,
            'buffCache' => $buffCache,
            'available' => $available,
        ];
    }

    public function all()
    {
        return [
            'up' => $this->up(),
            'upSince' => $this->upSince(),
            'memory' => $this->memory(),
        ];
    }
}
