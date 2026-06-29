<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class MarketOperations
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve known exchanges.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function exchanges(array $query = []): array
    {
        return $this->client->get('/v3/reference/exchanges', $query);
    }

    /**
     * Retrieve upcoming market holidays.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function upcomingHolidays(array $query = []): array
    {
        return $this->client->get('/v1/marketstatus/upcoming', $query);
    }

    /**
     * Retrieve the current market status.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function marketStatus(array $query = []): array
    {
        return $this->client->get('/v1/marketstatus/now', $query);
    }

    /**
     * Retrieve trade and quote condition codes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function conditionCodes(array $query = []): array
    {
        return $this->client->get('/v3/reference/conditions', $query);
    }
}
