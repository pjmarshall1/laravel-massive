<?php

namespace Pjmarshall1\Massive\Resources\Forex;

use Pjmarshall1\Massive\Massive;

class CurrencyConversion
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve real-time currency conversion rates.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function convert(string $from, string $to, array $query = []): array
    {
        return $this->client->get("/v1/conversion/{$from}/{$to}", $query);
    }
}
