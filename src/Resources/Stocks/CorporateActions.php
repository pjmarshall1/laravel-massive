<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class CorporateActions
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve initial public offerings.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ipos(array $query = [], bool $allPages = false): array
    {
        $path = '/vX/reference/ipos';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve stock split events.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function splits(array $query = [], bool $allPages = false): array
    {
        $path = '/stocks/v1/splits';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve dividend records.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dividends(array $query = [], bool $allPages = false): array
    {
        $path = '/stocks/v1/dividends';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve ticker event history.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function tickerEvents(string $id, array $query = []): array
    {
        return $this->client->get("/vX/reference/tickers/{$id}/events", $query);
    }
}
