<?php

require 'vendor/autoload.php';

use Chexwarrior\Crawler;

/**
 * 1. Make Login POST
 * 2. Parse outstading requests from table
 * 3. Check against save file
 * 4. Update file with new items
 * 5. Send notifications
 */

$username = $argv[1];
$password = $argv[2];

unlink('./test.html');
$crawler = new Crawler();
$html = $crawler->makePost($username, $password);
file_put_contents('./test.html', $html);
