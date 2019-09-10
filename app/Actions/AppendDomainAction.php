<?php

namespace App\Actions;

use Illuminate\Support\Str;

class AppendDomainAction
{
    /**
     * Iterates over the list of stories and extracts the domain, then adds that
     * domain as a new property to the story object.
     *
     * @param array $stories The list of stories to process
     * @return array The list of stories with the domain added to each story
     */
    public function execute($stories)
    {
        foreach ($stories as $story) {
            $host = $this->getHost($story->url);
            $domain = Str::replaceFirst('www.', '', $host);
            $story->domain = $domain;
        }
        return $stories;
    }

    private function getHost($url)
    {
        $urlParsed = parse_url($url);
        return data_get($urlParsed, 'host');
    }
}
