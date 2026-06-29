<?php

namespace Pjmarshall1\Massive\Resources\Options;

use Pjmarshall1\Massive\Massive;

class Snapshots
{
    public function __construct(protected Massive $client)
    {
        //
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
     * Retrieve an option chain snapshot for an underlying asset.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function chain(string $underlyingAsset, array $query = [], bool $allPages = false): array
    {
        $path = "/v3/snapshot/options/{$underlyingAsset}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve a snapshot for a single options contract.
     *
     * @return array<string, mixed>
     */
    public function contract(string $underlyingAsset, string $optionContract): array
    {
        return $this->client->get("/v3/snapshot/options/{$underlyingAsset}/{$optionContract}");
    }
}
