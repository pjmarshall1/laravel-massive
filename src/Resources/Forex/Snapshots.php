<?php

namespace Pjmarshall1\Massive\Resources\Forex;

use Pjmarshall1\Massive\Massive;

class Snapshots
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the latest snapshot for a single forex ticker.
     *
     * @return array<string, mixed>
     */
    public function singleTicker(string $ticker): array
    {
        return $this->client->get("/v2/snapshot/locale/global/markets/forex/tickers/{$ticker}");
    }

    /**
     * Retrieve the full market snapshot for forex tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function fullMarket(array $query = []): array
    {
        return $this->client->get('/v2/snapshot/locale/global/markets/forex/tickers', $query);
    }

    /**
     * Retrieve unified snapshots across supported asset classes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function unified(array $query = [], bool $allPages = false): array
    {
        $path = '/v3/snapshot';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve top forex market movers for a direction.
     *
     * @return array<string, mixed>
     */
    public function topMarketMovers(string $direction): array
    {
        return $this->client->get("/v2/snapshot/locale/global/markets/forex/{$direction}");
    }
}
