<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class Indicators
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the simple moving average for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function sma(string $ticker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/sma/{$ticker}", $query);
    }

    /**
     * Retrieve the exponential moving average for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ema(string $ticker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/ema/{$ticker}", $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function macd(string $ticker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/macd/{$ticker}", $query);
    }

    /**
     * Retrieve the relative strength index for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function rsi(string $ticker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/rsi/{$ticker}", $query);
    }
}
