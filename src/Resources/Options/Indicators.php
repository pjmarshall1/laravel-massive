<?php

namespace Pjmarshall1\Massive\Resources\Options;

use Pjmarshall1\Massive\Massive;

class Indicators
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the simple moving average for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function sma(string $optionsTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/sma/{$optionsTicker}", $query);
    }

    /**
     * Retrieve the exponential moving average for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ema(string $optionsTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/ema/{$optionsTicker}", $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function macd(string $optionsTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/macd/{$optionsTicker}", $query);
    }

    /**
     * Retrieve the relative strength index for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function rsi(string $optionsTicker, array $query = []): array
    {
        return $this->client->get("/v1/indicators/rsi/{$optionsTicker}", $query);
    }
}
