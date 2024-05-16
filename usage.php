<?php

require 'vendor/autoload.php';
require 'BitlyShortener.php';

use shortlink\BitlyShortener;

$accessToken = 'YOUR_ACCESS_TOKEN_HERE';

// Initialize BitlyShortener
$shortener = new BitlyShortener($accessToken);

// Shorten a URL
$longUrl = 'https://data.stackexchange.com/stackoverflow/query/58883/test-long-url';
$shortUrl = $shortener->shortenUrl(longUrl: $longUrl);
$qrCode = $shortener->generateQR($longUrl);
