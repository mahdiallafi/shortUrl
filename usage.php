<?php


require 'vendor/autoload.php';
require 'BitlyShortener.php';

use shortlink\BitlyShortener;

$accessToken = 'c79a7486c7e71cfdb8c9d7ff3f98adc3a1b2cd1f';

// Initialize BitlyShortener
$shortener = new BitlyShortener($accessToken);

// Shorten a URL
$longUrl = 'https://data.stackexchange.com/stackoverflow/query/58883/test-long-url';
$shortUrl = $shortener->shortenUrl(longUrl:$longUrl);

echo 'Short URL: ' . $shortUrl;
