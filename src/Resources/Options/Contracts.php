<?php

namespace Pjmarshall1\Massive\Resources\Options;

use Pjmarshall1\Massive\Massive;

class Contracts
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve options contracts.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function allContracts(array $query = [], bool $allPages = false): array
    {
        $path = '/v3/reference/options/contracts';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve an options contract overview.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function overview(string $optionsTicker, array $query = []): array
    {
        return $this->client->get("/v3/reference/options/contracts/{$optionsTicker}", $query);
    }
}
