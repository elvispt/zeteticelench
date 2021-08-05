<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class StaleTagsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testRemoveStaleTags()
    {
        $this->createTestTags();
        $this->artisan('tags:stale')
             ->expectsQuestion('This is a destructive command. Continue?', true)
             ->expectsOutput('Removed 6 stale tags.')
             ->assertExitCode(0);
    }

    public function testRemoveStaleTagsNoTagsOnDatabase()
    {
        $this->artisan('tags:stale')
             ->expectsQuestion('This is a destructive command. Continue?', true)
             ->expectsOutput('Removed 0 stale tags.')
             ->assertExitCode(0);
    }

    public function testRemoveStaleTagsNoConfirmation()
    {
        $this->artisan('tags:stale')
             ->expectsQuestion('This is a destructive command. Continue?', false)
             ->expectsOutput('Canceled!')
             ->assertExitCode(0);
    }

    /**
     * Will create 6 tags that can be removed.
     */
    protected function createTestTags()
    {
        User::factory()
            ->count(3)
            ->has(Tag::factory()->count(2))
            ->create([
                'created_at' => Carbon::now()->addWeeks(-10),
            ]);
    }
}
