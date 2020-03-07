<?php

namespace Tests\Feature\HackerNews;

use App\Jobs\HnImportStories;
use App\Repos\HackerNews\HackerNewsImport;
use App\Repos\HackerNews\HnApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class HackerNewsImportTest extends TestCase
{
    use RefreshDatabase;

    public function testImportTopStoriesIds()
    {
        Queue::fake();
        $cacheKey = 'testImportTopStoriesIds';
        $expiration = 10;
        $ids = [124, 879112482794, 42235, 7861254, 8761242352];
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->with($cacheKey, $ids, $expiration)
             ->andReturnTrue();

        $hnApiMock = $this->getMockBuilder(HnApi::class)
                          ->getMock();
        $hnApiMock
            ->expects($this->once())
            ->method('getLiveStoriesIdList')
            ->will($this->returnValue($ids));

        $hnApiMock
            ->expects($this->once())
            ->method('getTopStoriesUri')
            ->will($this->returnValue('unnecessary'));

        $hackerNewsImport = new HackerNewsImport();
        $hackerNewsImport
            ->setCacheKey($cacheKey)
            ->setExpiration($expiration)
            ->importTop($hnApiMock);
        Queue::assertPushed(
            HnImportStories::class,
            function ($job) use ($ids) {
                return $job->ids === $ids;
            });
    }

    public function testImportBestStoriesIds()
    {
        Queue::fake();
        $cacheKey = 'testImportBestStoriesIds';
        $expiration = 10;
        $ids = [767889, 879235182794, 897123524689, 7861254, 8761242];
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->with($cacheKey, $ids, $expiration)
             ->andReturnTrue();

        $hnApiMock = $this->getMockBuilder(HnApi::class)
                          ->getMock();
        $hnApiMock
            ->expects($this->once())
            ->method('getLiveStoriesIdList')
            ->will($this->returnValue($ids));

        $hnApiMock
            ->expects($this->once())
            ->method('getBestStoriesUri')
            ->will($this->returnValue('unnecessary'));

        $hackerNewsImport = new HackerNewsImport();
        $hackerNewsImport
            ->setCacheKey($cacheKey)
            ->setExpiration($expiration)
            ->importBest($hnApiMock);
        Queue::assertPushed(
            HnImportStories::class,
            function ($job) use ($ids) {
                return $job->ids === $ids;
            });
    }

    public function testImportNewStoriesIds()
    {
        Queue::fake();
        $cacheKey = 'testImportNewStoriesIds';
        $expiration = 10;
        $ids = [767889, 35, 897124689, 1, 8761242];
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->with($cacheKey, $ids, $expiration)
             ->andReturnTrue();

        $hnApiMock = $this->getMockBuilder(HnApi::class)
                          ->getMock();
        $hnApiMock
            ->expects($this->once())
            ->method('getLiveStoriesIdList')
            ->will($this->returnValue($ids));
        $hnApiMock
            ->expects($this->once())
            ->method('getNewStoriesUri')
            ->will($this->returnValue('unnecessary'));

        $hackerNewsImport = new HackerNewsImport();
        $hackerNewsImport
            ->setCacheKey($cacheKey)
            ->setExpiration($expiration)
            ->importNew($hnApiMock);
        Queue::assertPushed(
            HnImportStories::class,
            function ($job) use ($ids) {
                return $job->ids === $ids;
            });
    }

    public function testImportJobStoriesIds()
    {
        Queue::fake();
        $cacheKey = 'testImportJobStoriesIds';
        $expiration = 10;
        $ids = [45, 235, 142141241214, 235, 552];
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->with($cacheKey, $ids, $expiration)
             ->andReturnTrue();

        $hnApiMock = $this->getMockBuilder(HnApi::class)
                          ->getMock();
        $hnApiMock
            ->expects($this->once())
            ->method('getLiveStoriesIdList')
            ->will($this->returnValue($ids));
        $hnApiMock
            ->expects($this->once())
            ->method('getJobStoriesUri')
            ->will($this->returnValue('unnecessary'));

        $hackerNewsImport = new HackerNewsImport();
        $hackerNewsImport
            ->setCacheKey($cacheKey)
            ->setExpiration($expiration)
            ->importJobs($hnApiMock);
        Queue::assertPushed(
            HnImportStories::class,
            function ($job) use ($ids) {
                return $job->ids === $ids;
            });
    }

    public function testImportUpdatedStoriesIds()
    {
        $data = [
            (object) [
                'id' => 612,
                'parent' => 122223,
                'kids' => [242, 424, 242, 484, 328],
                'dead' => false,
                'url' => 'http://www.googl.ecom',
                'score' => 195,
                'title' => 'this is a title',
                'text' => 'this is the text',
                'time' => 98745456,
                'by' => 'somerandom',
                'descendants' => 8,
                'type' => 'story',
                'deleted' => true,
            ],
            (object) [
                'id' => 235672,
                'parent' => 323421,
                'kids' => [242, 484, 328],
                'dead' => false,
                'url' => 'http://wow',
                'score' => 350,
                'title' => 'this is a title',
                'text' => 'this is the text',
                //
                'time' => 98745456,
                'by' => 'bastard',
                'type' => 'story',
                'deleted' => true,
            ],
        ];
        $ids = [45222, 235142241, 142141241214, 235, 5529856, 4];
        $hnApiMock = $this->getMockBuilder(HnApi::class)
                          ->getMock();
        $hnApiMock
            ->expects($this->once())
            ->method('getLiveStoriesIdList')
            ->will($this->returnValue($ids));
        $hnApiMock
            ->expects($this->once())
            ->method('getUpdatesUri')
            ->will($this->returnValue('unnecessary'));
        $hnApiMock
            ->expects($this->once())
            ->method('concurrentRequestsForItems')
            ->will($this->returnValue($data));
        $hackerNewsImport = new HackerNewsImport();
        $hackerNewsImport->importUpdatedStories($hnApiMock);
        $this->assertDatabaseHas('hacker_news_items', [
            'id' => 612,
            'by' => 'somerandom',
            'type' => 'story',
            'parent_id' => 122223,
            'score' => 195,

        ]);
        $this->assertDatabaseHas('hacker_news_items', [
            'id' => 235672,
            'by' => 'bastard',
            'type' => 'story',
            'parent_id' => 323421,
            'score' => 350,
        ]);
    }
/*
    public function testImportUpdatedStories()
    {
        $cacheKey = HackerNewsImport::class . (new HnApi())->getJobStoriesUri();
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->with($cacheKey, [], 300)
             ->andReturnTrue();

        $hackerNewsImport = new HackerNewsImport();
        $hackerNewsImport->importUpdatedStories();
        $count = HackerNewsItem::count('id');
        $this->assertTrue($count > 0);
    }
*/
}
