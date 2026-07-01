<?php

namespace Pjmarshall1\Massive\Resources\Options\Stream;

class Business
{
    public function __construct(protected string $url)
    {
        //
    }

    public function url(): string
    {
        return $this->url;
    }

    /**
     * @param  array<int, string>|string  $tickers
     */
    public function fairMarketValue(array|string $tickers): string
    {
        return $this->channel('FMV', $tickers);
    }

    /**
     * @param  array<int, string>|string  $tickers
     */
    private function channel(string $prefix, array|string $tickers): string
    {
        return collect((array) $tickers)
            ->map(fn (string $ticker): string => "{$prefix}.{$ticker}")
            ->implode(',');
    }
}
