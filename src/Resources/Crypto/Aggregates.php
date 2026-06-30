<?php

namespace Pjmarshall1\Massive\Resources\Crypto;

use Pjmarshall1\Massive\Massive;

class Aggregates
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve custom aggregate bars for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function customBars(string $cryptoTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        $path = "/v2/aggs/ticker/{$cryptoTicker}/range/{$multiplier}/{$timespan}/{$from}/{$to}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve daily market summary bars for all crypto tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dailyMarketSummary(string $date, array $query = []): array
    {
        return $this->client->get("/v2/aggs/grouped/locale/global/market/crypto/{$date}", $query);
    }

    /**
     * Retrieve the daily open and close summary for a crypto pair.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dailyTickerSummary(string $from, string $to, string $date, array $query = []): array
    {
        return $this->client->get("/v1/open-close/crypto/{$from}/{$to}/{$date}", $query);
    }

    /**
     * Retrieve the previous close for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function previousClose(string $cryptoTicker, array $query = []): array
    {
        return $this->client->get("/v2/aggs/ticker/{$cryptoTicker}/prev", $query);
    }
}
