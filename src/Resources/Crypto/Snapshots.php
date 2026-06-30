<?php

namespace Pjmarshall1\Massive\Resources\Crypto;

use Pjmarshall1\Massive\Massive;

class Snapshots
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the latest snapshot for a single crypto ticker.
     *
     * @return array<string, mixed>
     */
    public function singleTicker(string $ticker): array
    {
        return $this->client->get("/v2/snapshot/locale/global/markets/crypto/tickers/{$ticker}");
    }

    /**
     * Retrieve the full market snapshot for crypto tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function fullMarket(array $query = []): array
    {
        return $this->client->get('/v2/snapshot/locale/global/markets/crypto/tickers', $query);
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
     * Retrieve top crypto market movers for a direction.
     *
     * @return array<string, mixed>
     */
    public function topMarketMovers(string $direction): array
    {
        return $this->client->get("/v2/snapshot/locale/global/markets/crypto/{$direction}");
    }
}
