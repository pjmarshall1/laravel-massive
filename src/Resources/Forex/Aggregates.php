<?php

namespace Pjmarshall1\Massive\Resources\Forex;

use Pjmarshall1\Massive\Massive;

class Aggregates
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve custom aggregate bars for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function customBars(string $forexTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        $path = "/v2/aggs/ticker/{$forexTicker}/range/{$multiplier}/{$timespan}/{$from}/{$to}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve daily market summary bars for all forex tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dailyMarketSummary(string $date, array $query = []): array
    {
        return $this->client->get("/v2/aggs/grouped/locale/global/market/fx/{$date}", $query);
    }

    /**
     * Retrieve the previous close for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function previousClose(string $forexTicker, array $query = []): array
    {
        return $this->client->get("/v2/aggs/ticker/{$forexTicker}/prev", $query);
    }
}
