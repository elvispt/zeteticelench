<?php

namespace App\Repos\RemoteJobs;

interface RemoteJobsInterface
{
    public const FORCE_CACHE_REFRESH = 2;

    public function jobs($forceCacheRefresh = null);
}
