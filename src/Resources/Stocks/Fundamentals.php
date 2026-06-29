<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class Fundamentals
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve balance sheet data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function balanceSheets(array $query = [], bool $allPages = false): array
    {
        return $this->getFinancials('/stocks/financials/v1/balance-sheets', $query, $allPages);
    }

    /**
     * Retrieve cash flow statement data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function cashFlowStatements(array $query = [], bool $allPages = false): array
    {
        return $this->getFinancials('/stocks/financials/v1/cash-flow-statements', $query, $allPages);
    }

    /**
     * Retrieve income statement data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function incomeStatements(array $query = [], bool $allPages = false): array
    {
        return $this->getFinancials('/stocks/financials/v1/income-statements', $query, $allPages);
    }

    /**
     * Retrieve financial ratios.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function ratios(array $query = [], bool $allPages = false): array
    {
        return $this->getFinancials('/stocks/financials/v1/ratios', $query, $allPages);
    }

    /**
     * Retrieve short interest data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function shortInterest(array $query = [], bool $allPages = false): array
    {
        return $this->getFinancials('/stocks/v1/short-interest', $query, $allPages);
    }

    /**
     * Retrieve short volume data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function shortVolume(array $query = [], bool $allPages = false): array
    {
        return $this->getFinancials('/stocks/v1/short-volume', $query, $allPages);
    }

    /**
     * Retrieve free float data.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function freeFloat(array $query = [], bool $allPages = false): array
    {
        return $this->getFinancials('/stocks/vX/float', $query, $allPages);
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    protected function getFinancials(string $path, array $query, bool $allPages): array
    {
        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
