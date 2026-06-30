<?php

namespace Pjmarshall1\Massive\Resources\Indices;

use Pjmarshall1\Massive\Massive;

class Aggregates
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve custom aggregate bars for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function customBars(string $indicesTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        $path = "/v2/aggs/ticker/{$indicesTicker}/range/{$multiplier}/{$timespan}/{$from}/{$to}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve the previous close for an index ticker.
     *
     * @return array<string, mixed>
     */
    public function previousClose(string $indicesTicker): array
    {
        return $this->client->get("/v2/aggs/ticker/{$indicesTicker}/prev");
    }

    /**
     * Retrieve daily open and close data for an index ticker.
     *
     * @return array<string, mixed>
     */
    public function dailyOpenClose(string $indicesTicker, string $date): array
    {
        return $this->client->get("/v1/open-close/{$indicesTicker}/{$date}");
    }
}
