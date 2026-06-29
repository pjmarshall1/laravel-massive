<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class Tickers
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve stock tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function allTickers(array $query = [], bool $allPages = false): array
    {
        if ($allPages) {
            return $this->client->getAllPages('/v3/reference/tickers', $query);
        }

        return $this->client->get('/v3/reference/tickers', $query);
    }

    /**
     * Retrieve a stock ticker overview.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function overview(string $ticker, array $query = []): array
    {
        return $this->client->get("/v3/reference/tickers/{$ticker}", $query);
    }

    /**
     * Retrieve ticker types.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function types(array $query = []): array
    {
        return $this->client->get('/v3/reference/tickers/types', $query);
    }

    /**
     * Retrieve related tickers for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function related(string $ticker, array $query = []): array
    {
        return $this->client->get("/v1/related-companies/{$ticker}", $query);
    }
}
