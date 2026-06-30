<?php

namespace Pjmarshall1\Massive\Resources\Indices;

use Pjmarshall1\Massive\Massive;

class Snapshots
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve snapshots for one or more indices.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function indices(array $query = [], bool $allPages = false): array
    {
        $path = '/v3/snapshot/indices';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
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
}
