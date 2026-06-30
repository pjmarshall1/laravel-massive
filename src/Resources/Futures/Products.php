<?php

namespace Pjmarshall1\Massive\Resources\Futures;

use Pjmarshall1\Massive\Massive;

class Products
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve futures products.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function allProducts(array $query = [], bool $allPages = false): array
    {
        $path = '/futures/v1/products';

        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
