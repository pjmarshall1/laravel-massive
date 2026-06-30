<?php

namespace Pjmarshall1\Massive\Resources;

use Pjmarshall1\Massive\Massive;
use Pjmarshall1\Massive\Resources\Futures\Contracts;

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
}
