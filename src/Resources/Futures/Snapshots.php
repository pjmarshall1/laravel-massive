<?php

namespace Pjmarshall1\Massive\Resources\Futures;

use Pjmarshall1\Massive\Massive;

class Snapshots
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve futures contract snapshots.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function contractSnapshots(array $query = [], bool $allPages = false): array
    {
        $path = '/futures/v1/snapshot';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
