<?php

namespace Pjmarshall1\Massive\Resources\Stocks\Stream;

class Delayed
{
    /**
     * @param  array<int, string>|string  $tickers
     */
    public function aggregatesPerSecond(array|string $tickers): string
    {
        return $this->channel('A', $tickers);
    }

    /**
     * @param  array<int, string>|string  $tickers
     */
    public function aggregatesPerMinute(array|string $tickers): string
    {
        return $this->channel('AM', $tickers);
    }

    /**
     * @param  array<int, string>|string  $tickers
     */
    public function trades(array|string $tickers): string
    {
        return $this->channel('T', $tickers);
    }

    /**
     * @param  array<int, string>|string  $tickers
     */
    public function quotes(array|string $tickers): string
    {
        return $this->channel('Q', $tickers);
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
