<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class Snapshots
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the latest snapshot for a single stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function singleTicker(string $ticker, array $query = []): array
    {
        return $this->client->get("/v2/snapshot/locale/us/markets/stocks/tickers/{$ticker}", $query);
    }

    /**
     * Retrieve the full market snapshot for all stock tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function fullMarket(array $query = []): array
    {
        return $this->client->get('/v2/snapshot/locale/us/markets/stocks/tickers', $query);
    }

    /**
     * Retrieve unified snapshots across supported asset classes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function unified(array $query = []): array
    {
        return $this->client->get('/v3/snapshot', $query);
    }

    /**
     * Retrieve top stock market movers for a direction.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function topMarketMovers(string $direction, array $query = []): array
    {
        return $this->client->get("/v2/snapshot/locale/us/markets/stocks/{$direction}", $query);
    }
}
