<?php

namespace Pjmarshall1\Massive\Resources\Crypto;

use Pjmarshall1\Massive\Massive;

class Trades
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve historical trades for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historical(string $cryptoTicker, array $query = [], bool $allPages = false): array
    {
        $path = "/v3/trades/{$cryptoTicker}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve the latest trade for a crypto pair.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function latest(string $from, string $to, array $query = []): array
    {
        return $this->client->get("/v1/last/crypto/{$from}/{$to}", $query);
    }
}
