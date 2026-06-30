<?php

namespace Pjmarshall1\Massive\Resources\Futures;

use Pjmarshall1\Massive\Massive;

class Aggregates
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve aggregate bars for a futures contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function aggregateBars(string $ticker, array $query = [], bool $allPages = false): array
    {
        $path = "/futures/v1/aggs/{$ticker}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
