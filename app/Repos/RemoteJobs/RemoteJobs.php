<?php

namespace App\Repos\RemoteJobs;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class RemoteJobs
{
    protected $sources = [];

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

        return $jobs->values()->toArray();
    }
}
