<?php

namespace Pjmarshall1\Massive\Resources\Futures;

use Pjmarshall1\Massive\Massive;

class Schedules
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve futures schedules.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function allSchedules(array $query = [], bool $allPages = false): array
    {
        $path = '/futures/v1/schedules';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
