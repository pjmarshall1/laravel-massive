<?php

namespace Pjmarshall1\Massive\Resources\Indices;

use Pjmarshall1\Massive\Massive;

class Indicators
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the simple moving average for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function sma(string $indicesTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/sma/{$indicesTicker}", $query);
    }

    /**
     * Retrieve the exponential moving average for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ema(string $indicesTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/ema/{$indicesTicker}", $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function macd(string $indicesTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/macd/{$indicesTicker}", $query);
    }

    /**
     * Retrieve the relative strength index for an index ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function rsi(string $indicesTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/rsi/{$indicesTicker}", $query);
    }
}
