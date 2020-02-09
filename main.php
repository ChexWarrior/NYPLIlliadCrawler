<?php

require 'vendor/autoload.php';

use Chexwarrior\Crawler;
use Chexwarrior\Parser;

$username = $argv[1];
$password = $argv[2];

// 1. Make Login POST
$crawler = new Crawler();
$html = $crawler->makePost($username, $password);

// 2. Parse oustanding requests from table
$parser = new Parser();
$outstandingRequests = $parser->parseOutstandingRequests($html);

echo json_encode($outstandingRequests);

// 3. Check against save file


// 4. Update file with new items

// 5. Send notifications
