<?php

require 'vendor/autoload.php';

use Chexwarrior\Crawler;
use Chexwarrior\Parser;

/**
 * 1. Make Login POST
 * 2. Parse outstanding requests from table
 * 3. Check against save file
 * 4. Update file with new items
 * 5. Send notifications
 */

$username = $argv[1];
$password = $argv[2];

$crawler = new Crawler();
$parser = new Parser();

$html = $crawler->makePost($username, $password);
$outstandingRequests = $parser->parseOutstandingRequests($html);

var_dump($outstandingRequests);
