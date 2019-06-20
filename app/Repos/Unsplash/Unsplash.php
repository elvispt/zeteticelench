<?php

namespace App\Repos\Unsplash;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;

class Unsplash
{
    protected $cacheKey;

    protected $cacheExpiration = 330;

    public function __construct(
        ?string $cacheKey = null,
        ?int $cacheExpiration = null
    ) {
        $this->cacheKey = $cacheKey ? $cacheKey : Unsplash::class;
        $this->cacheExpiration = $cacheExpiration ? $cacheExpiration : 330;
    }

    /**
     * Gets a featured image from Unsplash API
     *
     * @param UnsplashApi $unsplashApi       The unsplash api class if required
     *                                       to make api requests
     * @param bool        $forceCacheRefresh Forcefully get a new image. When
     *                                       false it will always attempt to
     *                                       obtain first from cache.
     * @return object|null Returns the path (url) to the unsplash image and a
     *                     background color to use
     */
    public function getUnsplashFeaturedImage(
        UnsplashApi $unsplashApi,
        $forceCacheRefresh = false
    ) {
        if ($forceCacheRefresh) {
            $photoUrl = $this->fromApi($unsplashApi);
        } else {
            $photoUrl = Cache::get($this->cacheKey);
            if (is_null($photoUrl)) {
                $photoUrl = $this->fromApi($unsplashApi);
            }
        }

        return $photoUrl;
    }

    /**
     * Obtains image from API and stores on cache
     *
     * @param UnsplashApi $unsplashApi The unsplash api class, if requires to
     *                                 to make api requests
     * @return object|null Returns the path (url) to the unsplash image and a
     *                     background color to use
     */
    protected function fromApi(UnsplashApi $unsplashApi)
    {
        $photoUrl = $unsplashApi->getFeaturedImage();
        try {
            Cache::set($this->cacheKey, $photoUrl, $this->cacheExpiration);
        } catch (InvalidArgumentException $exception) {
            Log::warning("Could not store photoUrl into cache");
        }
        return $photoUrl;
    }
}
