<?php

namespace Pjmarshall1\Massive\Resources\Futures;

use Pjmarshall1\Massive\Massive;

class Trades
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve historical trades for a futures contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historical(string $ticker, array $query = [], bool $allPages = false): array
    {
        $path = "/futures/v1/trades/{$ticker}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
