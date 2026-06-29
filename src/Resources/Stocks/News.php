<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class News
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve stock news articles.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function articles(array $query = [], bool $allPages = false): array
    {
        $path = '/v2/reference/news';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
