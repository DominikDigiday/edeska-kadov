<?php
/**
 * RSS proxy pre úradnú dosku (kadov.imunis.cz)
 * - obchádza CORS
 * - cachuje výsledok na 10 minút
 *
 * Umiestni na server vedľa index.html.
 */

declare(strict_types=1);

const FEED_URL   = 'https://kadov.imunis.cz/edeska/feed/rss';
const CACHE_FILE = __DIR__ . '/.edeska-cache.xml';
const CACHE_TTL  = 600; // 10 minút

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/rss+xml; charset=utf-8');

if (is_file(CACHE_FILE) && (time() - filemtime(CACHE_FILE)) < CACHE_TTL) {
    readfile(CACHE_FILE);
    exit;
}

$ctx = stream_context_create([
    'http' => [
        'timeout' => 8,
        'header'  => "User-Agent: edeska-modul/1.0\r\n",
    ],
]);

$xml = @file_get_contents(FEED_URL, false, $ctx);

if ($xml === false) {
    if (is_file(CACHE_FILE)) {
        readfile(CACHE_FILE);
        exit;
    }
    http_response_code(502);
    echo '<?xml version="1.0"?><rss><channel><title>Feed nedostupný</title></channel></rss>';
    exit;
}

file_put_contents(CACHE_FILE, $xml, LOCK_EX);
echo $xml;
