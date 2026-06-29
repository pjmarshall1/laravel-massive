<?php

namespace Pjmarshall1\Massive\Exceptions;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Throwable;

class MassiveRequestException extends MassiveException
{
    public function __construct(
        protected string $path,
        protected Response $response,
        ?Throwable $previous = null,
    ) {
        parent::__construct($this->messageFor($path, $response), $response->status(), $previous);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function response(): Response
    {
        return $this->response;
    }

    public function status(): int
    {
        return $this->response->status();
    }

    public static function fromRequestException(string $path, RequestException $exception): static
    {
        return new static($path, $exception->response, $exception);
    }

    protected function messageFor(string $path, Response $response): string
    {
        return sprintf('Massive request to [%s] failed with status [%d].', $path, $response->status());
    }
}
