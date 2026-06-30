<?php

namespace Pjmarshall1\Massive\Resources\Options;

use Pjmarshall1\Massive\Massive;

class Quotes
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve historical quotes for an options contract.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historical(string $optionsTicker, array $query = [], bool $allPages = false): array
    {
        $path = "/v3/quotes/{$optionsTicker}";

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
