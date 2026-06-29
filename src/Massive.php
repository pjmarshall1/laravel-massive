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
        return $this->get('/v3/reference/dividends', $query);
    }

    /**
     * Retrieve custom aggregate bars for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function customBars(string $ticker, int $multiplier, string $timespan, string $from, string $to, array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->aggregates()->customBars($ticker, $multiplier, $timespan, $from, $to, $query, $allPages);
    }

    /**
     * Retrieve grouped daily bars for the entire US stocks market.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function groupedDaily(string $date, array $query = []): array
    {
        return $this->stocks()->aggregates()->groupedDaily($date, $query);
    }

    /**
     * Retrieve daily open and close data for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function dailyOpenClose(string $ticker, string $date, array $query = []): array
    {
        return $this->stocks()->aggregates()->dailyOpenClose($ticker, $date, $query);
    }

    /**
     * Retrieve the previous close for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function previousClose(string $ticker, array $query = []): array
    {
        return $this->stocks()->aggregates()->previousClose($ticker, $query);
    }

    /**
     * Retrieve the latest snapshot for a single stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function singleTickerSnapshot(string $ticker, array $query = []): array
    {
        return $this->stocks()->snapshots()->singleTicker($ticker, $query);
    }

    /**
     * Retrieve the full market snapshot for all stock tickers.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function fullMarketSnapshot(array $query = []): array
    {
        return $this->stocks()->snapshots()->fullMarket($query);
    }

    /**
     * Retrieve unified snapshots across supported asset classes.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function unifiedSnapshot(array $query = []): array
    {
        return $this->stocks()->snapshots()->unified($query);
    }

    /**
     * Retrieve top stock market movers for a direction.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function topMarketMovers(string $direction, array $query = []): array
    {
        return $this->stocks()->snapshots()->topMarketMovers($direction, $query);
    }

    /**
     * Retrieve historical trades for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historicalTrades(string $ticker, array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->trades()->historical($ticker, $query, $allPages);
    }

    /**
     * Retrieve the latest trade for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function latestTrade(string $ticker, array $query = []): array
    {
        return $this->stocks()->trades()->latest($ticker, $query);
    }

    /**
     * Retrieve historical quotes for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function historicalQuotes(string $ticker, array $query = [], bool $allPages = false): array
    {
        return $this->stocks()->quotes()->historical($ticker, $query, $allPages);
    }

    /**
     * Retrieve the latest quote for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function latestQuote(string $ticker, array $query = []): array
    {
        return $this->stocks()->quotes()->latest($ticker, $query);
    }

    /**
     * Retrieve the simple moving average for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function sma(string $ticker, array $query = []): array
    {
        return $this->stocks()->indicators()->sma($ticker, $query);
    }

    /**
     * Retrieve the exponential moving average for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ema(string $ticker, array $query = []): array
    {
        return $this->stocks()->indicators()->ema($ticker, $query);
    }

    /**
     * Retrieve the moving average convergence/divergence for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function macd(string $ticker, array $query = []): array
    {
        return $this->stocks()->indicators()->macd($ticker, $query);
    }

    /**
     * Retrieve the relative strength index for a stock ticker.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function rsi(string $ticker, array $query = []): array
    {
        return $this->stocks()->indicators()->rsi($ticker, $query);
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
