<?php

namespace Pjmarshall1\Massive\Resources\Futures;

use Pjmarshall1\Massive\Massive;

class Contracts
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve futures contracts.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function allContracts(array $query = [], bool $allPages = false): array
    {
        $path = '/futures/v1/contracts';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
