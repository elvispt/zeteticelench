<?php

namespace Tests\Feature\HackerNews;

use App\Models\HackerNewsItem;
use App\Models\User;
use App\Repos\HackerNews\CollapsedComments;
use App\Repos\HackerNews\ItemType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CollapsedCommentsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCollapsedComments()
    {
        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first()
            ->id;
        factory(HackerNewsItem::class, 100)
            ->create();
        $id = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $collapsedComments = new CollapsedComments($userId, $id);
        $cacheKey = $collapsedComments->getCacheKey();
        $expectedIdList = [87967, 7861, 2, 97, 43];
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturn($expectedIdList);

        $listOfCollapsedItemIds = $collapsedComments->getCollapsedComments();
        $this->assertIsArray($listOfCollapsedItemIds);
        $this->assertEquals($expectedIdList, $listOfCollapsedItemIds);
    }

    public function testGetCollapsedCommentsShouldBeEmpty()
    {
        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first()
            ->id;
        factory(HackerNewsItem::class, 100)
            ->create();
        $id = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $collapsedComments = new CollapsedComments($userId, $id);
        $cacheKey = $collapsedComments->getCacheKey();
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturnNull();

        $listOfCollapsedItemIds = $collapsedComments->getCollapsedComments();
        $this->assertIsArray($listOfCollapsedItemIds);
        $this->assertEquals([], $listOfCollapsedItemIds);
    }

    public function testSetCommentAsCollapsed()
    {
        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first()
            ->id;
        factory(HackerNewsItem::class, 100)
            ->create();
        $storyId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $commentId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::COMMENT)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $collapsedComments = new CollapsedComments($userId, $storyId);
        $cacheKey = $collapsedComments->getCacheKey();
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturnNull();
        Cache::shouldReceive('set')
             ->with($cacheKey, [$commentId], $collapsedComments->getCacheTtl())
             ->andReturnTrue();

        $result = $collapsedComments->collapse($commentId);
        $this->assertTrue($result);
    }

    public function testAppendCommentAsCollapsed()
    {
        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first()
            ->id;
        factory(HackerNewsItem::class, 100)
            ->create();
        $storyId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $commentId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::COMMENT)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $collapsedComments = new CollapsedComments($userId, $storyId);
        $cacheKey = $collapsedComments->getCacheKey();
        $existingCollapsedComments = [1124, 154, 423];
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturn($existingCollapsedComments);
        $toCache = $existingCollapsedComments;
        $toCache[] = $commentId;
        Cache::shouldReceive('set')
             ->with($cacheKey, $toCache, $collapsedComments->getCacheTtl())
             ->andReturnTrue();

        $result = $collapsedComments->collapse($commentId);
        $this->assertTrue($result);
    }

    public function testRemoveCommentAsCollapsedShouldFailOnEmptyList()
    {
        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first()
            ->id;
        factory(HackerNewsItem::class, 100)
            ->create();
        $storyId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $commentId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::COMMENT)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $collapsedComments = new CollapsedComments($userId, $storyId);
        $cacheKey = $collapsedComments->getCacheKey();
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturnNull();
        $result = $collapsedComments->removeCollapsed($commentId);
        $this->assertFalse($result);
    }

    public function testRemoveCommentAsCollapsed()
    {
        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first()
            ->id;
        factory(HackerNewsItem::class, 100)
            ->create();
        $storyId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $commentId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::COMMENT)
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;
        $collapsedComments = new CollapsedComments($userId, $storyId);
        $cacheKey = $collapsedComments->getCacheKey();
        $existingCollapsedComments = [154, $commentId, 423];
        Cache::shouldReceive('get')
             ->with($cacheKey)
             ->andReturn($existingCollapsedComments);
        $toCache = [154, 423];
        Cache::shouldReceive('set')
             ->with($cacheKey, $toCache, $collapsedComments->getCacheTtl())
             ->andReturnTrue();

        $result = $collapsedComments->removeCollapsed($commentId);
        $this->assertTrue($result);
    }
}
