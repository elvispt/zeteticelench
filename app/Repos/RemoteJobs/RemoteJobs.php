<?php

namespace App\Repos\RemoteJobs;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RemoteJobs
{
    protected $sources = [];

    protected $cacheKey = self::class;

    protected $cacheTtl = 3660;

    public function __construct()
    {
        $this->sources[] = HackerNewsJobs::class;
        $this->sources[] = GithubJobs::class;
    }

    /**
     * @return array<Job>
     */
    public function jobs()
    {
        $jobsList = Cache::get(self::class);

        if (is_null($jobsList)) {
            $jobs = new Collection();
            foreach ($this->sources as $sourceClassPath) {
                /**
                 * @var RemoteJobsInterface $sourceObject
                 */
                try {
                    $sourceObject = new $sourceClassPath();
                } catch (Exception $exception) {
                    $sourceObject = [];
                    Log::error(
                        'Could not instantiate class with provided path',
                        [
                            'eMessage' => $exception->getMessage(),
                            '$sourceClassPath' => $sourceClassPath,
                        ]
                    );
                }
                $jobs = $jobs->merge($sourceObject->jobs());
            }

            $jobsList = $jobs->values()->toArray();

            Cache::set($this->cacheKey, $jobsList, $this->cacheTtl);
        }

        return $jobsList;
    }
}
