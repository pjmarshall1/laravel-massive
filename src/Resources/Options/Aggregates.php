<?php

namespace Pjmarshall1\Massive\Resources\Options;

use Pjmarshall1\Massive\Massive;

class Aggregates
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve custom aggregate bars for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function customBars(string $optionsTicker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        $path = "/v2/aggs/ticker/{$optionsTicker}/range/{$multiplier}/{$timespan}/{$from}/{$to}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
