<?php

namespace Pjmarshall1\Massive;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Pjmarshall1\Massive\Resources\Stocks;

class Massive
{
    /**
     * @param  array<int, int>  $retryDelays
     */
    public function __construct(
        protected ?string $apiKey,
        protected string $baseUrl,
        protected int $timeout,
        protected int $connectTimeout,
        protected array $retryDelays,
    ) {
        //
    }

    public function stocks(): Stocks
    {
        return new Stocks($this);
    }

    /**
     * Retrieve reference ticker details.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function tickerDetails(string $ticker, array $query = []): array
    {
        return $this->stocks()->tickers()->overview($ticker, $query);
    }

    /**
     * Retrieve dividend records.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dividends(array $query = []): array
    {
        return $this->stocks()->dividends($query);
    }

    /**
     * Send a GET request to a Massive REST endpoint.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string $path, array $query = []): array
    {
        $path = $this->normalizePath($path);

        $response = $query === []
            ? $this->requestFor($path)->get($path)
            : $this->requestFor($path)->get($path, $query);

        return $response
            ->throw()
            ->json();
    }

    /**
     * Send GET requests until a paginated Massive endpoint has no next page.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function getAllPages(string $path, array $query = [], string $resultsKey = 'results'): array
    {
        $response = $this->get($path, $query);
        $results = $response[$resultsKey] ?? [];
        $nextUrl = $response['next_url'] ?? null;

        while (is_string($nextUrl) && $nextUrl !== '') {
            $nextResponse = $this->get($nextUrl);

            $results = [
                ...$results,
                ...($nextResponse[$resultsKey] ?? []),
            ];

            $nextUrl = $nextResponse['next_url'] ?? null;
        }

        $response[$resultsKey] = $results;
        unset($response['next_url']);

        return $response;
    }

    public function request(): PendingRequest
    {
        return $this->baseRequest()->baseUrl($this->baseUrl);
    }

    protected function requestFor(string $path): PendingRequest
    {
        $request = $this->baseRequest();

        if (! $this->isAbsoluteUrl($path)) {
            $request = $request->baseUrl($this->baseUrl);
        }

        return $request;
    }

    protected function baseRequest(): PendingRequest
    {
        $request = Http::acceptJson()
            ->timeout($this->timeout)
            ->connectTimeout($this->connectTimeout);

        if (is_string($this->apiKey) && $this->apiKey !== '') {
            $request = $request->withToken($this->apiKey);
        }

        if ($this->retryDelays !== []) {
            $request = $request->retry($this->retryDelays);
        }

        return $request;
    }

    protected function normalizePath(string $path): string
    {
        if ($this->isAbsoluteUrl($path)) {
            return $path;
        }

        return '/'.ltrim($path, '/');
    }

    protected function isAbsoluteUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }
}
