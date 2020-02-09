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
        $crawler = new Crawler($html);

        // Filter to Outstanding Requests Table rows
        $crawler = $crawler->filter('#content div.default-table table tbody tr');
        $outstandingRequests = $crawler->each(function (Crawler $tr, $i) {
            return [
                'transaction' => $tr->filterXPath('/td[1]'),
                'title' => $tr->filterXPath('/td[3]'),
                'status' => $tr->filterXPath('/td[5]'),
            ];
        });

        return $outstandingRequests;
    }
}
