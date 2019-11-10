<?php


namespace App\Repos\RemoteJobs;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class GithubJobs implements RemoteJobsInterface
{
    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $jobsUri;

    /**
     * @var string
     */
    protected $cacheKey;

    protected $cacheTll = 600;

    public function __construct($cacheKey = 'GithubJobs')
    {
        $this->baseUri = 'https://jobs.github.com';
        $this->jobsUri = '/positions.json';
        $this->cacheKey = $cacheKey;
    }

    public function jobs($forceCacheRefresh = null)
    {
        $jobs = $this->getFromCache($forceCacheRefresh);
        if (is_null($jobs)) {
            $response = $this->apiRequest();
            $apiParsedResponse = $this->parseApiResponse($response);
            $jobs = $this->parse($apiParsedResponse);
            Cache::put($this->cacheKey, $jobs, $this->cacheTll);
        }

        return $jobs;
    }

    protected function getFromCache($forceCacheRefresh = null)
    {
        if ($forceCacheRefresh === self::FORCE_CACHE_REFRESH) {
            Cache::forget($this->cacheKey);
            return null;
        }
        return Cache::get($this->cacheKey);
    }

    /**
     * @return ResponseInterface|null
     */
    protected function apiRequest()
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
            'connect_timeout' => 2,
            'headers' => [
                'Accept: application/json',
            ],
        ]);
        $response = null;
        try {
            $response = $client->get($this->jobsUri, [
                'query' => [
                    'description' => 'php',
                    'location' => 'remote',
                ],
            ]);
        } catch (Exception $exception) {
            Log::alert(
                "Failed to make request to Github Jobs",
                ['eMessage' => $exception->getMessage()]
            );
        }
        return $response;
    }


    /**
     * Parses the github api response
     *
     * @param ResponseInterface|null $response The response from the API.
     *
     * @return mixed|null Returns the parsed response from the API
     */
    protected function parseApiResponse(?ResponseInterface $response = null)
    {
        if (is_null($response)) {
            return null;
        }
        $json = $response->getBody()->getContents();
        $jobs = null;
        try {
            $jobs = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::warning(
                "Could not parse Github Jobs response",
                ['eMessage' => $exception->getMessage()]
            );
        }

        return $jobs;
    }

    /**
     * @param array|null $apiParsedResponse
     *
     * @return Collection
     */
    protected function parse(array $apiParsedResponse = null)
    {
        if (is_null($apiParsedResponse)) {
            return new Collection();
        }

        return (new Collection($apiParsedResponse))
            ->map(static function ($ghJob) {
                $job = new Job();
                $job->source = 'gh';
                $job->id = data_get($ghJob, 'id');
                $job->title = data_get($ghJob, 'title');
                $job->text = data_get($ghJob, 'description');
                $job->companyUrl = data_get($ghJob, 'company_url');
                $job->url = data_get($ghJob, 'url');
                $job->howToApply = data_get($ghJob, 'how_to_apply');
                $time = data_get($ghJob, 'created_at');
                $job->time = Carbon::createFromFormat('D M d H:i:s e Y', $time);

                return $job;
            })
            ->filter();
    }
}
