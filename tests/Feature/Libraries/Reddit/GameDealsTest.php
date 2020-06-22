<?php

namespace Tests\Feature\Libraries\Reddit;

use App\Libraries\Reddit\GameDeals;
use App\Libraries\Reddit\GameDealsFree;
use App\Mail\GameDealFound;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class GameDealsTest extends TestCase
{
    use RefreshDatabase;

    public function testGameDealsRedditApiFails()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $gameDealsFree = \Mockery::mock(GameDealsFree::class);
        $gameDealsFree->shouldReceive('getDeals')
            ->andReturn(new Collection())
            ->once();

        $gameDeals = new GameDeals($gameDealsFree);
        $gameDeals->run();

        Mail::assertNothingSent();
    }

    public function testGameDealsSentNoNotificaion()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $apiData = [
            (object) [
                'kind' => 't3',
                'data' => (object) [
                    'id' => 'hclecj',
                    'title' => '[IndieGala] Ubersoldier II 53%',
                    'permalink' => '/r/GameDeals/comments/hclecj/indiegala_ubersoldier_ii_100_offfree/',
                    'url' => 'https://freebies.indiegala.com/ubersoldier-ii/',
                ]
            ],
            (object) [
                'kind' => 't3',
                'data' => (object) [
                    'id' => 'f42ecj',
                    'title' => '[Steam] Ubersoldier II',
                    'permalink' => '/r/GameDeals/comments/hclecj/indiegala_ubersoldier_ii_100_offfree/',
                    'url' => 'https://freebies.indiegala.com/ubersoldier-ii/',
                ]
            ],
        ];

        $gameDealsFree = \Mockery::mock(GameDealsFree::class);
        $gameDealsFree->shouldReceive('getDeals')
                      ->andReturn(new Collection($apiData))
                      ->once();

        $gameDeals = new GameDeals($gameDealsFree);
        $gameDeals->run();
        Mail::assertNothingSent();
    }

    public function testGameDealsSentMultipleEmailNotifications()
    {
        Mail::fake();
        Mail::assertNothingSent();

        $apiData = [
            (object) [
                'kind' => 't3',
                'data' => (object) [
                    'id' => 'hclecj',
                    'title' => '[IndieGala] Ubersoldier II (100% off/Free)',
                    'permalink' => '/r/GameDeals/comments/hclecj/indiegala_ubersoldier_ii_100_offfree/',
                    'url' => 'https://freebies.indiegala.com/ubersoldier-ii/',
                ]
            ],
            (object) [
                'kind' => 't3',
                'data' => (object) [
                    'id' => 'f42ecj',
                    'title' => '[Steam] Ubersoldier II',
                    'permalink' => '/r/GameDeals/comments/hclecj/indiegala_ubersoldier_ii_100_offfree/',
                    'url' => 'https://freebies.indiegala.com/ubersoldier-ii/',
                ]
            ],
            (object) [
                'kind' => 't3',
                'data' => (object) [
                    'id' => 'fkjnbdg',
                    'title' => '[Steam] Half Life III 100% Free',
                    'permalink' => '/r/GameDeals/comments/hclecj/indiegala_ubersoldier_ii_100_offfree/',
                    'url' => 'https://freebies.indiegala.com/ubersoldier-ii/',
                ]
            ],
            (object) [
                'kind' => 't3',
                'data' => (object) [
                    'id' => 'huy67t34',
                    'title' => '[Epic] GTAV [Free]',
                    'permalink' => '/r/GameDeals/comments/hclecj/indiegala_ubersoldier_ii_100_offfree/',
                    'url' => 'https://freebies.indiegala.com/ubersoldier-ii/',
                ]
            ],
            (object) [
                'kind' => 't3',
                'data' => (object) [
                    'id' => 'buhyif47',
                    'title' => '[Steam] GTAV [15% Off]',
                    'permalink' => '/r/GameDeals/comments/hclecj/indiegala_ubersoldier_ii_100_offfree/',
                    'url' => 'https://freebies.indiegala.com/ubersoldier-ii/',
                ]
            ],
        ];

        $gameDealsFree = \Mockery::mock(GameDealsFree::class);
        $gameDealsFree->shouldReceive('getDeals')
                      ->andReturn(new Collection($apiData))
                      ->once();

        $gameDeals = new GameDeals($gameDealsFree);
        $gameDeals->run();
        Mail::assertSent(GameDealFound::class, 3);
    }
}
