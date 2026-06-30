<?php

namespace Pjmarshall1\Massive\Resources\Options;

use Pjmarshall1\Massive\Massive;

class Trades
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve historical trades for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historical(string $optionsTicker, array $query = [], bool $allPages = false): array
    {
        $path = "/v3/trades/{$optionsTicker}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve the latest trade for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function latest(string $optionsTicker, array $query = []): array
    {
        return $this->client->get("/v2/last/trade/{$optionsTicker}", $query);
    }
}
