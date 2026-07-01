<?php

namespace Pjmarshall1\Massive\Resources\Forex\Stream;

class RealTime
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
    public function aggregatesPerSecond(array|string $tickers): string
    {
        return $this->channel('CAS', $tickers);
    }

    /**
     * @param  array<int, string>|string  $tickers
     */
    public function aggregatesPerMinute(array|string $tickers): string
    {
        return $this->channel('CA', $tickers);
    }

    /**
     * @param  array<int, string>|string  $tickers
     */
    public function quotes(array|string $tickers): string
    {
        return $this->channel('C', $tickers);
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
