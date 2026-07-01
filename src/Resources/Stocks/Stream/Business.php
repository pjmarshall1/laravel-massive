<?php

namespace Pjmarshall1\Massive\Resources\Stocks\Stream;

class Business
{
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
