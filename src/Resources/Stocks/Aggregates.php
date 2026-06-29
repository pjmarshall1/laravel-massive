<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class Aggregates
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve custom aggregate bars for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function customBars(string $ticker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        $path = "/v2/aggs/ticker/{$ticker}/range/{$multiplier}/{$timespan}/{$from}/{$to}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve grouped daily bars for the entire US stocks market.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function groupedDaily(string $date, array $query = []): array
    {
        return $this->client->get("/v2/aggs/grouped/locale/us/market/stocks/{$date}", $query);
    }

    /**
     * Retrieve daily open and close data for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dailyOpenClose(string $ticker, string $date, array $query = []): array
    {
        return $this->client->get("/v1/open-close/{$ticker}/{$date}", $query);
    }

    /**
     * Retrieve the previous close for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function previousClose(string $ticker, array $query = []): array
    {
        return $this->client->get("/v2/aggs/ticker/{$ticker}/prev", $query);
    }
}
