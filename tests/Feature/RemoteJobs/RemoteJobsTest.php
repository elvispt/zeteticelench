<?php

namespace Feature\RemoteJobs;

use App\Models\HackerNewsItem;
use App\Repos\RemoteJobs\RemoteJobs;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoteJobsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testRemoteJobs()
    {
        factory(HackerNewsItem::class, 100)
            ->create();

        $remoteJobs = new RemoteJobs();
        $jobs = $remoteJobs->jobs();
        $this->assertIsArray($jobs);
        $this->assertNotEmpty($jobs);
    }
}
