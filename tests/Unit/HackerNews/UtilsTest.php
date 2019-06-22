<?php

namespace Tests\Unit\HackerNews;

use App\Repos\HackerNews\Utils;
use Tests\TestCase;

class UtilsTest extends TestCase
{
    public function testSortStories()
    {
        $unorderedStories = [
            (object) ['id' => 5],
            (object) ['id' => 6],
            (object) ['id' => 7],
            (object) ['id' => 8],
            (object) ['id' => 9],
            (object) ['id' => 1],
            (object) ['id' => 2],
            (object) ['id' => 3],
            (object) ['id' => 4],
        ];
        $expectedOrder = [9, 8, 7, 6, 5, 1, 2, 3, 4];
        $sortedStories = Utils::sortStoriesList($unorderedStories, $expectedOrder);

        $this->assertIsArray($sortedStories);
        foreach ($sortedStories as $index => $story) {
            $this->assertEquals($story->id, $expectedOrder[$index]);
        }
        $this->assertCount(count($expectedOrder), $sortedStories);
    }

    public function testSortStoriesRemovedStoriesNotOnSortOrder()
    {
        $unorderedStories = [
            (object) ['id' => 5],
            (object) ['id' => 6],
            (object) ['id' => 7],
            (object) ['id' => 8],
            (object) ['id' => 9],
            (object) ['id' => 1],
            (object) ['id' => 2],
            (object) ['id' => 3],
            (object) ['id' => 4],
        ];
        $expectedOrder = [9, 2, 3, 4];
        $sortedStories = Utils::sortStoriesList($unorderedStories, $expectedOrder);

        $this->assertIsArray($sortedStories);
        foreach ($sortedStories as $index => $story) {
            $this->assertEquals($story->id, $expectedOrder[$index]);
        }
        $this->assertCount(count($expectedOrder), $sortedStories);
    }

    public function testSortStoriesRemovedStoriesNotOnSortOrdersAll()
    {
        $unorderedStories = [
            (object) ['id' => 5],
            (object) ['id' => 6],
            (object) ['id' => 7],
            (object) ['id' => 8],
            (object) ['id' => 9],
            (object) ['id' => 1],
            (object) ['id' => 2],
            (object) ['id' => 3],
            (object) ['id' => 4],
        ];
        $expectedOrder = [10, 20, 30];
        $sortedStories = Utils::sortStoriesList($unorderedStories, $expectedOrder);

        $this->assertIsArray($sortedStories);
        foreach ($sortedStories as $index => $story) {
            $this->assertEquals($story->id, $expectedOrder[$index]);
        }
        $this->assertCount(0, $sortedStories);
    }

    public function testSortStoriesWithNoSortingOrderSent()
    {
        $unorderedStories = [
            (object) ['id' => 5],
            (object) ['id' => 6],
            (object) ['id' => 7],
            (object) ['id' => 8],
            (object) ['id' => 9],
            (object) ['id' => 1],
            (object) ['id' => 2],
            (object) ['id' => 3],
            (object) ['id' => 4],
        ];
        $expectedOrder = [];
        $sortedStories = Utils::sortStoriesList($unorderedStories, $expectedOrder);

        $this->assertIsArray($sortedStories);
        foreach ($sortedStories as $index => $story) {
            $this->assertEquals($story->id, $expectedOrder[$index]);
        }
        $this->assertCount(count($expectedOrder), $sortedStories);
    }
}
