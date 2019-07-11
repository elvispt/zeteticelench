<?php

namespace Tests\Unit;

use App\Repos\Unsplash\Unsplash;
use App\Repos\Unsplash\UnsplashApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use Tests\TestCase;

class UnsplashTest extends TestCase
{
    public function testGetUnsplashFeaturedImageFromCache()
    {
        $data = (object) [
            'url' => 'http://www.testGetUnsplashFeaturedImageFromCache.com',
            'bg' => '#FFF'
        ];
        Cache::shouldReceive('get')
             ->once()
             ->with(Unsplash::class)
             ->andReturn($data);
        $mock = $this->getMockBuilder(UnsplashApi::class)
            ->getMock();
        $unsplash = new Unsplash();
        $featuredImage = $unsplash->getUnsplashFeaturedImage($mock);
        $this->assertIsObject($featuredImage);
        $this->assertObjectHasAttribute('url', $featuredImage);
        $this->assertObjectHasAttribute('bg', $featuredImage);
        $this->assertEquals($data->url, $featuredImage->url);
        $this->assertEquals($data->bg, $featuredImage->bg);
    }

    public function testGetUnsplashFeaturedImageFromApi()
    {
        $expiration = 2148;
        $data = (object) [
            'url' => 'http://www.testGetUnsplashFeaturedImageFromApi.com',
            'bg' => '#FFF'
        ];
        Cache::shouldReceive('get')
             ->once()
             ->with(Unsplash::class)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->once()
             ->with(Unsplash::class, $data, $expiration)
             ->andReturnTrue();
        $mock = $this->getMockBuilder(UnsplashApi::class)
                     ->getMock();
        $mock
            ->expects($this->once())
            ->method('getFeaturedImage')
            ->will($this->returnValue($data));
        $unsplash = new Unsplash(null, $expiration);
        $featuredImage = $unsplash->getUnsplashFeaturedImage($mock);
        $this->assertIsObject($featuredImage);
        $this->assertObjectHasAttribute('url', $featuredImage);
        $this->assertObjectHasAttribute('bg', $featuredImage);
        $this->assertEquals($data->url, $featuredImage->url);
        $this->assertEquals($data->bg, $featuredImage->bg);
    }

    public function testGetUnsplashFeaturedImageFromApiWithForcedRefresh()
    {
        $expiration = 123;
        $dataFromApi = (object) [
            'url' => 'http://www.randomimage.com/aAPIimage.jpg',
            'bg' => '#FFF'
        ];
        Cache::shouldReceive('set')
             ->once()
             ->with(Unsplash::class, $dataFromApi, $expiration)
             ->andReturnTrue();
        $mock = $this->getMockBuilder(UnsplashApi::class)
                     ->getMock();
        $mock
            ->expects($this->once())
            ->method('getFeaturedImage')
            ->will($this->returnValue($dataFromApi));
        $unsplash = new Unsplash(null, $expiration);
        $featuredImage = $unsplash->getUnsplashFeaturedImage($mock, true);
        $this->assertIsObject($featuredImage);
        $this->assertObjectHasAttribute('url', $featuredImage);
        $this->assertObjectHasAttribute('bg', $featuredImage);
        $this->assertEquals($dataFromApi->url, $featuredImage->url);
        $this->assertEquals($dataFromApi->bg, $featuredImage->bg);
    }

    public function testGetUnsplashFeaturedImageFromApiWithCacheSetFailure()
    {
        Cache::shouldReceive('get')
             ->once()
             ->with(Unsplash::class)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->once()
             ->andThrowExceptions([new InvalidArgumentException("invalid key", 666)]);
        Log::shouldReceive('warning')
           ->with("Could not store photoUrl into cache");
        $mock = $this->getMockBuilder(UnsplashApi::class)
                     ->getMock();
        $mock
            ->expects($this->once())
            ->method('getFeaturedImage')
            ->will($this->returnValue(new \stdClass()));
        $unsplash = new Unsplash(null, 666);
        $featuredImage = $unsplash->getUnsplashFeaturedImage($mock);
        $this->assertIsObject($featuredImage);
    }
}
