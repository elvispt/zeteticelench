<?php

return [
    'base_uri' => 'https://api.unsplash.com',
    'random_photo_endpoint' => '/photos/random',
    'access_key' => env('UNSPLASH_ACCESS_KEY'),
    'search_query_values' => [
        'code',
        'technology',
        'programming',
        'earth',
        'natural',
        'architecture',
        'abstract',
        'texture',
        'wall',
        'network',
    ],
];
