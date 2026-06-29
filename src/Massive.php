<?php

namespace Pjmarshall1\Massive;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

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

    /**
     * Retrieve aggregate bars for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function aggregates(
        string $ticker,
        int $multiplier,
        string $timespan,
        string $from,
        string $to,
        array $query = [],
    ): array {
        if ($multiplier < 1) {
            throw new InvalidArgumentException('The aggregate multiplier must be greater than zero.');
        }

        return $this->get(
            sprintf('/v2/aggs/ticker/%s/range/%d/%s/%s/%s', $ticker, $multiplier, $timespan, $from, $to),
            $query,
        );
    }

    /**
     * Retrieve reference ticker details.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function tickerDetails(string $ticker, array $query = []): array
    {
        return $this->get("/v3/reference/tickers/{$ticker}", $query);
    }

    /**
     * Retrieve dividend records.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dividends(array $query = []): array
    {
        return $this->get('/v3/reference/dividends', $query);
    }

    /**
     * Send a GET request to a Massive REST endpoint.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string $path, array $query = []): array
    {
        return $this->request()
            ->get($this->normalizePath($path), $query)
            ->throw()
            ->json();
    }

    public function request(): PendingRequest
    {
        $request = Http::baseUrl($this->baseUrl)
            ->acceptJson()
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
        return '/'.ltrim($path, '/');
    }
}
