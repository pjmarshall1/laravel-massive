<?php

namespace Pjmarshall1\Massive\Resources\Forex;

use Pjmarshall1\Massive\Massive;

class Quotes
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve historical quotes for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historical(string $fxTicker, array $query = [], bool $allPages = false): array
    {
        $path = "/v3/quotes/{$fxTicker}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve the latest quote for a forex currency pair.
     *
     * @return array<string, mixed>
     */
    public function latest(string $from, string $to): array
    {
        return $this->client->get("/v1/last_quote/currencies/{$from}/{$to}");
    }
}
