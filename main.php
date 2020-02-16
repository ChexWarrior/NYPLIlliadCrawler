<?php

require 'vendor/autoload.php';

use Chexwarrior\Crawler;
use Chexwarrior\Parser;
use Chexwarrior\Saver;

define('SAVE_FILE_PATH', './save.json');

$username = $argv[1];
$password = $argv[2];

// 1. Make Login POST
$crawler = new Crawler();
$html = $crawler->makePost($username, $password);

// 2. Parse oustanding requests from table
$parser = new Parser();
$newRequests = $parser->parseOutstandingRequests($html);

echo json_encode($newRequests);

// 3. Check against save file
$saver = new Saver();
$savedRequests = $saver->loadFile(SAVE_FILE_PATH);

if (!empty($savedRequests)) {
    $newRequests = $saver->determineChangedRequests($newRequests, $savedRequests);
}

// 4. Update file with new items
$saver->saveFile(SAVE_FILE_PATH, $newRequests);

// 5. Send notifications
