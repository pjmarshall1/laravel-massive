<?php

namespace Pjmarshall1\Massive\Resources\Crypto;

use Pjmarshall1\Massive\Massive;

class Indicators
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the simple moving average for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function sma(string $cryptoTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/sma/{$cryptoTicker}", $query);
    }

    /**
     * Retrieve the exponential moving average for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ema(string $cryptoTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/ema/{$cryptoTicker}", $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function macd(string $cryptoTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/macd/{$cryptoTicker}", $query);
    }

    /**
     * Retrieve the relative strength index for a crypto ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function rsi(string $cryptoTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/rsi/{$cryptoTicker}", $query);
    }
}
