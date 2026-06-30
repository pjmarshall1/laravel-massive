<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Futures\Contracts;
use Pjmarshall1\Massive\Resources\Futures\Products;

class Futures
{
    public function __construct(protected Massive $client)
    {
        //
    }

    public function contracts(): Contracts
    {
        return new Contracts($this->client);
    }

    public function products(): Products
    {
        return new Products($this->client);
    }
}
