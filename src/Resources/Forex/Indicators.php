<?php

namespace Pjmarshall1\Massive\Resources\Forex;

use Pjmarshall1\Massive\Massive;

class Indicators
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the simple moving average for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function sma(string $fxTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/sma/{$fxTicker}", $query);
    }

    /**
     * Retrieve the exponential moving average for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ema(string $fxTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/ema/{$fxTicker}", $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function macd(string $fxTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/macd/{$fxTicker}", $query);
    }

    /**
     * Retrieve the relative strength index for a forex ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function rsi(string $fxTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/rsi/{$fxTicker}", $query);
    }
}
