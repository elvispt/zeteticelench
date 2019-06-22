<?php

namespace Tests\Unit;

use App\Repos\HackerNews\StoreItems;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreItemsTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreStories()
    {
        $stories = [
            // valid
            (object) [
                'id' => 5,
                'type' => 'story',
            ],
            // invalid
            (object) [
                'id' => 6,
                'parent' => 123,
                'kids' => [242, 424, 242, 484, 328],
                'dead' => true,
                'url' => 'http://www.googl.ecom',
                'score' => 12416,
                'title' => 'this is a title',
                'text' => 'this is the text',
            ],
            // valid
            (object) [
                'id' => 6,
                'parent' => 123,
                'kids' => [242, 424, 242, 484, 328],
                'dead' => false,
                'url' => 'http://www.googl.ecom',
                'score' => 351,
                'title' => 'this is a title',
                'text' => 'this is the text',
                //
                'time' => 98745456,
                'by' => 'somerandom',
                'descendants' => 8,
                'type' => 'story',
                'deleted' => true,
            ],
            // valid
            (object) [
                'id' => 79,
                'type' => 'WTF',
            ],
        ];

        $storeItems = new StoreItems();
        $nStories = $storeItems->store($stories);
        $this->assertEquals(2, $nStories);
        $this->assertDatabaseHas('hacker_news_items', [
            'id' => 6,
            'parent_id' => 123,
            'text' => 'this is the text',
            'by' => 'somerandom',
        ]);
        $this->assertDatabaseHas('hacker_news_items', [
            'id' => 5,
            'type' => 'story',
        ]);
    }

    public function testStoreStoriesNoValidStories()
    {
        $stories = [
            // valid
            (object) [
                'id' => 5,
                'type' => 'story23',
            ],
            // invalid
            (object) [
                'id' => 6,
                'parent' => 123,
                'kids' => [242, 424, 242, 484, 328],
                'dead' => true,
                'url' => 'http://www.googl.ecom',
                'score' => 12416,
                'title' => 'this is a title',
                'text' => 'this is the text',
            ],
            // invalid
            (object) [
                'id' => 6,
                'parent' => 123,
                'kids' => [242, 424, 242, 484, 328],
                'dead' => false,
                'url' => 'http://www.googl.ecom',
                'score' => 351124122224124,
                'title' => 'this is a title',
                'text' => 'this is the text',
                //
                'time' => 98745456,
                'by' => 'somerandom',
                'descendants' => 8,
                'type' => 'story',
                'deleted' => true,
            ],
            // invalid
            (object) [
                'id' => 79,
                'type' => 'WTF',
            ],
        ];

        $storeItems = new StoreItems();
        $nStories = $storeItems->store($stories);
        $this->assertEquals(0, $nStories);
    }

    public function testStoreStoriesChangedItems()
    {
        $stories = [
            // valid
            (object) [
                'id' => 5,
                'type' => 'story',
            ],
            // invalid
            (object) [
                'id' => 6,
                'parent' => 123,
                'kids' => [242, 424, 242, 484, 328],
                'dead' => true,
                'url' => 'http://www.googl.ecom',
                'score' => 12416,
                'title' => 'this is a title',
                'text' => 'this is the text',
            ],
            // valid
            (object) [
                'id' => 6,
                'parent' => 123,
                'kids' => [242, 424, 242, 484, 328],
                'dead' => false,
                'url' => 'http://www.googl.ecom',
                'score' => 351,
                'title' => 'this is a title',
                'text' => 'this is the text',
                'time' => 98745456,
                'by' => 'somerandom',
                'descendants' => 8,
                'type' => 'story',
                'deleted' => true,
            ],
            // invalid
            (object) [
                'id' => 79,
                'type' => 'WTF',
            ],
            // valid
            (object) [
                'id' => 6,
                'parent' => 321,
                'kids' => [242, 484, 328],
                'dead' => false,
                'url' => 'http://wow',
                'score' => 351,
                'title' => 'this is a title',
                'text' => 'this is the text',
                //
                'time' => 98745456,
                'by' => 'somerandom',
                'type' => 'story',
                'deleted' => true,
            ],
        ];

        $storeItems = new StoreItems();
        $nStories = $storeItems->store($stories);
        $this->assertEquals(3, $nStories);
        $this->assertDatabaseHas('hacker_news_items', [
            'id' => 6,
            'parent_id' => 321,
            'text' => 'this is the text',
            'by' => 'somerandom',
        ]);
        $this->assertDatabaseHas('hacker_news_items', [
            'id' => 5,
            'type' => 'story',
        ]);
        $changed = $storeItems->getChanges();
        $this->assertEquals(2, $changed['new']);
        $this->assertEquals(1, $changed['updated']);
    }
}
