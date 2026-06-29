<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Stocks\Tickers;

class Stocks
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function tickers(): Tickers
    {
        return new Tickers($this->client);
    }

    /**
     * Retrieve dividend records.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dividends(array $query = []): array
    {
        return $this->client->get('/v3/reference/dividends', $query);
    }
}
