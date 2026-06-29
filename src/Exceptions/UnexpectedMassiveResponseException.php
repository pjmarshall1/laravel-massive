<?php

namespace Pjmarshall1\Massive\Exceptions;

class UnexpectedMassiveResponseException extends MassiveException
{
    public function __construct(protected string $path)
    {
        parent::__construct(sprintf('Massive request to [%s] returned an unexpected response.', $path));
    }

    public function path(): string
    {
        return $this->path;
    }
}
