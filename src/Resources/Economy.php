<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;

class Economy
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve treasury yield data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function treasuryYields(array $query = [], bool $allPages = false): array
    {
        $path = '/fed/v1/treasury-yields';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve inflation data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function inflation(array $query = [], bool $allPages = false): array
    {
        $path = '/fed/v1/inflation';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve inflation expectation data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function inflationExpectations(array $query = [], bool $allPages = false): array
    {
        $path = '/fed/v1/inflation-expectations';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve labor market data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function laborMarket(array $query = [], bool $allPages = false): array
    {
        $path = '/fed/v1/labor-market';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
