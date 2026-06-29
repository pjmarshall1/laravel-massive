<?php

namespace Pjmarshall1\Massive\Resources\Stocks;

use Pjmarshall1\Massive\Massive;

class Filings
{
    public function __construct(protected Massive $client)
    {
        //
    }

    /**
     * Retrieve the SEC EDGAR filings index.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function edgarIndex(array $query = [], bool $allPages = false): array
    {
        return $this->getFilings('/stocks/filings/vX/index', $query, $allPages);
    }

    /**
     * Retrieve 10-K filing sections.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function tenKSections(array $query = [], bool $allPages = false): array
    {
        return $this->getFilings('/stocks/filings/10-K/vX/sections', $query, $allPages);
    }

    /**
     * Retrieve 8-K filing text.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function eightKText(array $query = [], bool $allPages = false): array
    {
        return $this->getFilings('/stocks/filings/8-K/vX/text', $query, $allPages);
    }

    /**
     * Retrieve 13-F filings.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function thirteenF(array $query = [], bool $allPages = false): array
    {
        return $this->getFilings('/stocks/filings/vX/13-F', $query, $allPages);
    }

    /**
     * Retrieve standardized risk factor disclosures.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function riskFactors(array $query = [], bool $allPages = false): array
    {
        return $this->getFilings('/stocks/filings/vX/risk-factors', $query, $allPages);
    }

    /**
     * Retrieve the risk factor taxonomy.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function riskCategories(array $query = []): array
    {
        return $this->client->get('/stocks/taxonomies/vX/risk-factors', $query);
    }

    /**
     * Retrieve Form 3 filings.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function form3(array $query = [], bool $allPages = false): array
    {
        return $this->getFilings('/stocks/filings/vX/form-3', $query, $allPages);
    }

    /**
     * Retrieve Form 4 filings.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function form4(array $query = [], bool $allPages = false): array
    {
        return $this->getFilings('/stocks/filings/vX/form-4', $query, $allPages);
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    protected function getFilings(string $path, array $query, bool $allPages): array
    {
        if ($allPages) {
            return $this->client->getAllPages($path, $query);
        }

        return $this->client->get($path, $query);
    }
}
