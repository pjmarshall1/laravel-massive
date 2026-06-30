<?php

namespace Pjmarshall1\Massive\Resources\Futures;

use Pjmarshall1\Massive\Massive;

class MarketOperations
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve current futures market status records.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function marketStatus(array $query = [], bool $allPages = false): array
    {
        $path = '/futures/v1/market-status';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve supported futures exchanges.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function exchanges(array $query = [], bool $allPages = false): array
    {
        $path = '/futures/v1/exchanges';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
