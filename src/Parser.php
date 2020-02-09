<?php

namespace Chexwarrior;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Parses status of each active transaction
 *
 * @package Chexwarrior
 */
class Parser
{
    public function parseOutstandingRequests(string $html)
    {
        $outstandingRequests = [];
        $crawler = new Crawler($html);

        // Filter to Outstan/ding Requests Table rows
        $crawler = $crawler->filter('#content div.default-table table tbody tr');
        $crawler->each(function (Crawler $tr, $i) use (&$outstandingRequests) {
            $transactionId = $tr->filterXPath('//td[1]')->text();
            $outstandingRequests[$transactionId] = [
                'title' => $tr->filterXPath('//td[3]')->text(),
                'status' => $tr->filterXPath('//td[5]')->text(),
            ];
        });

        return $outstandingRequests;
    }
}
