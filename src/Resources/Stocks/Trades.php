<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class Trades
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve historical trades for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historical(string $ticker, array $query = [], bool $allPages = false): array
    {
        $path = "/v3/trades/{$ticker}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve the latest trade for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function latest(string $ticker, array $query = []): array
    {
        return $this->client->get("/v2/last/trade/{$ticker}", $query);
    }
}
