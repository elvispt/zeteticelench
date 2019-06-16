<?php

return [
    'site_url' => 'https://news.ycombinator.com',
    'api_base_uri' => 'https://hacker-news.firebaseio.com',
    'api_top_stories_uri' => '/v0/topstories.json',
    'api_best_stories_uri' => '/v0/beststories.json',
    'api_job_stories_uri' => '/v0/jobstories.json',
    'api_updates_uri' => '/v0/updates.json',
    'api_item_details_uri_format' => '/v0/item/%s.json',
    'api_item_max_id' => '/v0/maxitem.json',

    'list_limit' => 15,

    'api_full_import_active' => env('HN_FULL_IMPORT_ENABLED', false),
];
