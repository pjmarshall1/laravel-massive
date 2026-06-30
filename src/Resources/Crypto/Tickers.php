<?php

namespace Pjmarshall1\Massive\Resources\Crypto;

use Pjmarshall1\Massive\Massive;

class Tickers
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve crypto tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function allTickers(array $query = [], bool $allPages = false): array
    {
        $path = '/v3/reference/tickers';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve a crypto ticker overview.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function overview(string $ticker, array $query = []): array
    {
        return $this->client->get("/v3/reference/tickers/{$ticker}", $query);
    }
}
