<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;

class Alternative
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve European consumer spending merchant aggregates.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function merchantAggregates(array $query = [], bool $allPages = false): array
    {
        $path = '/consumer-spending/eu/v1/merchant-aggregates';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }

    /**
     * Retrieve European consumer spending merchant hierarchy reference data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function merchantHierarchy(array $query = [], bool $allPages = false): array
    {
        $path = '/consumer-spending/eu/v1/merchant-hierarchy';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
